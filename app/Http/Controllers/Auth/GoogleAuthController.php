<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirect(): RedirectResponse
    {
        $clientId    = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');

        if (empty($clientId) || empty($redirectUri)) {
            Session::flash('error', get_phrase('Google login is not configured.'));
            return redirect()->route('login');
        }

        $state = Str::random(40);
        Session::put('google_oauth_state', $state);

        $params = [
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'prompt'        => 'select_account',
            'state'         => $state,
        ];

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    /**
     * Handle the OAuth callback from Google.
     * Note: this controller is invoked from the existing /login route when
     * Google redirects back with ?code=... so we share the same redirect URI.
     */
    public function callback(Request $request)
    {
        // Validate state
        $sessionState = Session::pull('google_oauth_state');
        if (!$sessionState || $sessionState !== $request->query('state')) {
            Session::flash('error', get_phrase('Invalid Google login state. Please try again.'));
            return redirect()->route('login');
        }

        if ($request->filled('error')) {
            Session::flash('error', get_phrase('Google login was cancelled.'));
            return redirect()->route('login');
        }

        $code = $request->query('code');
        if (!$code) {
            Session::flash('error', get_phrase('Google did not return an authorization code.'));
            return redirect()->route('login');
        }

        $clientId     = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri  = config('services.google.redirect');

        $http = new Client(['timeout' => 15, 'http_errors' => false]);

        // Exchange code for access token
        try {
            $tokenResp = $http->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'code'          => $code,
                    'client_id'     => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect_uri'  => $redirectUri,
                    'grant_type'    => 'authorization_code',
                ],
            ]);

            $tokenData = json_decode((string) $tokenResp->getBody(), true);
            if (!isset($tokenData['access_token'])) {
                Log::warning('Google OAuth token exchange failed', ['response' => $tokenData]);
                Session::flash('error', get_phrase('Could not authenticate with Google.'));
                return redirect()->route('login');
            }

            // Fetch user info
            $userResp = $http->get('https://www.googleapis.com/oauth2/v3/userinfo', [
                'headers' => ['Authorization' => 'Bearer ' . $tokenData['access_token']],
            ]);
            $googleUser = json_decode((string) $userResp->getBody(), true);
        } catch (\Throwable $e) {
            Log::error('Google OAuth network error: ' . $e->getMessage());
            Session::flash('error', get_phrase('Could not reach Google. Please try again.'));
            return redirect()->route('login');
        }

        if (empty($googleUser['email'])) {
            Session::flash('error', get_phrase('Google did not return an email address.'));
            return redirect()->route('login');
        }

        $email = strtolower(trim($googleUser['email']));
        $name  = trim($googleUser['name'] ?? Str::before($email, '@'));
        $photo = $googleUser['picture'] ?? null;

        // Find or create the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name'              => $name,
                'email'             => $email,
                'role'              => 'student',
                'status'            => 1,
                'email_verified_at' => Carbon::now(),
                'password'          => Hash::make(Str::random(40)),
                'photo'             => $photo,
            ]);
            Session::flash('success', get_phrase('Welcome! Your account has been created.'));
        } else {
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // Route by role (default RouteServiceProvider::HOME usually goes to dashboard)
        return redirect()->intended(url('/'));
    }
}
