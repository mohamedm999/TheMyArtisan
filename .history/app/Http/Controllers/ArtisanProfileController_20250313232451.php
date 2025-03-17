<?php

namespace App\Http\Controllers\Artisan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{
    // ...existing code...

    /**
     * Store work experience for artisan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWorkExperience(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $isCurrentJob = $request->has('is_current');

        // Create a new work experience record using the field names that match the database columns
        $workExperience = new \App\Models\WorkExperience();
        $workExperience->user_id = $user->id;
        $workExperience->position = $request->title;
        $workExperience->company_name = $request->company;
        $workExperience->start_date = $request->start_date;
        $workExperience->end_date = $isCurrentJob ? null : $request->end_date;
        $workExperience->is_current = $isCurrentJob;
        $workExperience->description = $request->description;
        $workExperience->save();

        // Debug log to help identify issues
        \Log::info('Work experience created with ID: ' . $workExperience->id);

        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully!');
    }

    // ...existing code...
}
