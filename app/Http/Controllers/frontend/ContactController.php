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

        // check duplicate
        if (Contact::where('email', $request->email)->exists()) {
            Session::flash('error', get_phrase('This email has been taken.'));
            return redirect()->back();
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
            $html = "<h3>New Contact Message</h3>
                     <p><strong>Name:</strong> {$request->name}</p>
                     <p><strong>Email:</strong> {$request->email}</p>
                     <p><strong>Phone:</strong> {$request->phone}</p>
                     <p><strong>Address:</strong> {$request->address}</p>
                     <p><strong>Message:</strong><br/>" . nl2br($request->message) . "</p>";

            \Illuminate\Support\Facades\Mail::html($html, function($msg) use ($request) {
                $msg->to('info@swissbridgeacademy.com')
                    ->subject('New Contact Form Submission - ' . $request->name)
                    ->replyTo($request->email, $request->name);
            });
        } catch (\Exception $e) {
            // Ignore email fail silently to not break user experience
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

        try {
            $html = "<h3>New Instructor Application</h3>
                     <p><strong>Name:</strong> {$request->name}</p>
                     <p><strong>Email:</strong> {$request->email}</p>
                     <p><strong>Phone:</strong> {$request->phone}</p>
                     <p><strong>Cover Letter / Message:</strong><br/>" . nl2br($request->message) . "</p>
                     <p><em>Please find the attached CV.</em></p>";

            \Illuminate\Support\Facades\Mail::html($html, function($msg) use ($request) {
                $msg->to('info@swissbridgeacademy.com')
                    ->subject('New Instructor Application: ' . $request->name)
                    ->replyTo($request->email, $request->name);
                
                if ($request->hasFile('cv')) {
                    $msg->attach($request->file('cv')->getRealPath(), [
                        'as' => $request->file('cv')->getClientOriginalName(),
                        'mime' => $request->file('cv')->getMimeType()
                    ]);
                }
            });

            Session::flash('success', get_phrase('Your application has been submitted successfully. We will contact you soon!'));
        } catch (\Exception $e) {
            \Log::error('Instructor Mail Error: ' . $e->getMessage());
            Session::flash('error', get_phrase('Failed to send application. Please try again later.') . ' Error: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
