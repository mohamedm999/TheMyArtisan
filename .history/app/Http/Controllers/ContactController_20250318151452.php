<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validate form input
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required|accepted',
        ]);

        try {
            // In production, you would send an email here
            // Mail::to('contact@myartisan.ma')->send(new ContactFormSubmission($validated));

            // For now, just log the submission
            Log::info('Contact form submission received', [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'subject' => $validated['subject']
            ]);

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was a problem sending your message. Please try again.'])->withInput();
        }
    }
}
