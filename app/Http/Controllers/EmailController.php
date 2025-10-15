<?php

namespace App\Http\Controllers;
use App\Mail\NewMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'sender_email' => 'required|email',
            'receiver_email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = [
            'sender_email' => $request->sender_email,
            'receiver_email' => $request->receiver_email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            // Mail::raw('Test email content', function ($message) {
            //     $message->to('recipient@example.com')
            //             ->from('silvainduwara60@gmail.com')
            //             ->subject('Test Email');
            // });

            Mail::to($data['receiver_email'])->send(new NewMailable($data));

             return back()->with('success', 'Email sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    } //
}
