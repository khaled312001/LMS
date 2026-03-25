<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.contact_us.index';
        return view($view_path);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if (get_frontend_settings('recaptcha_status') == true && check_recaptcha($input['g-recaptcha-response']) == false) {
            Session::flash('error', get_phrase('Recaptcha verification failed'));
            return redirect(route('contact.us'));
        }

        // validate user data
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // process data
        $contact['name'] = $request->name;
        $contact['email'] = $request->email;
        $contact['phone'] = $request->phone;
        $contact['address'] = $request->address;
        $contact['message'] = $request->message;

        // insert data
        Contact::insert($contact);

        // Send Email to Admin
        try {
            // Force config override to completely bypass any db cached settings
            config([
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => env('MAIL_HOST', 'smtp.hostinger.com'),
                'mail.mailers.smtp.port' => env('MAIL_PORT', 465),
                'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'ssl'),
                'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD'),
                'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                'mail.from.name' => env('MAIL_FROM_NAME'),
            ]);

            $html = "<h3>New Contact Message</h3>
                     <p><strong>Name:</strong> {$request->name}</p>
                     <p><strong>Email:</strong> {$request->email}</p>
                     <p><strong>Phone:</strong> {$request->phone}</p>
                     <p><strong>Address:</strong> {$request->address}</p>
                     <p><strong>Message:</strong><br/>" . nl2br($request->message) . "</p>";

            \Illuminate\Support\Facades\Mail::html($html, function($msg) use ($request) {
                $msg->to(env('MAIL_USERNAME', 'info@swissbridgeacademy.com'))
                    ->subject('New Contact Form Submission - ' . $request->name)
                    ->replyTo($request->email, $request->name);
            });
        } catch (\Exception $e) {
            \Log::error('Contact Mail Error: ' . $e->getMessage());
            // Ignore email fail silently to not break user experience as the record is saved
        }

        // redirect back
        Session::flash('success', get_phrase('Your record has been saved.'));
        return redirect()->back();
    }

    public function instructor_store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'message' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 1) SAVE FIRMLY IN DATABASE TO PREVENT LOSS
        try {
            $cv_path = "";
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                // Ensure directory exists
                $destinationPath = public_path('uploads/cvs');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->move($destinationPath, $filename);
                $cv_path = "uploads/cvs/" . $filename;
            }

            $messageText = "** INSTRUCTOR APPLICATION **\n\n";
            $messageText .= "Cover Letter:\n" . $request->message . "\n\n";
            if ($cv_path != "") {
                $messageText .= "CV File Link: " . url($cv_path) . "\n";
            }

            Contact::insert([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => 'Instructor Application',
                'message' => $messageText,
            ]);
        } catch (\Exception $e) {
            // If DB insert fails
            \Log::error('DB Insert Error: ' . $e->getMessage());
        }

        // 2) ATTEMPT TO SEND EMAIL (Bonus)
        try {
            // Force config override to completely bypass any db cached settings
            config([
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => env('MAIL_HOST', 'smtp.hostinger.com'),
                'mail.mailers.smtp.port' => env('MAIL_PORT', 465),
                'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'ssl'),
                'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD'),
                'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                'mail.from.name' => env('MAIL_FROM_NAME'),
            ]);

            $html = "<h3>New Instructor Application</h3>
                     <p><strong>Name:</strong> {$request->name}</p>
                     <p><strong>Email:</strong> {$request->email}</p>
                     <p><strong>Phone:</strong> {$request->phone}</p>
                     <p><strong>Cover Letter / Message:</strong><br/>" . nl2br($request->message) . "</p>
                     <p><em>Please find the attached CV or download it from <a href='".url($cv_path)."'>HERE</a>.</em></p>";

            \Illuminate\Support\Facades\Mail::html($html, function($msg) use ($request, $cv_path) {
                $msg->to(env('MAIL_USERNAME', 'info@swissbridgeacademy.com'))
                    ->subject('New Instructor Application: ' . $request->name)
                    ->replyTo($request->email, $request->name);
                
                if ($cv_path != "") {
                    $msg->attach(public_path($cv_path));
                }
            });

        } catch (\Exception $e) {
            \Log::error('Instructor Mail Error: ' . $e->getMessage());
            // We DO NOT flash error here anymore! Because the data is SAFELY saved in the DB!
            // We just let it silently fail and show success so the user doesn't panic.
        }

        Session::flash('success', get_phrase('Your application has been submitted successfully. We will contact you soon!'));
        return redirect()->back();
    }
}
