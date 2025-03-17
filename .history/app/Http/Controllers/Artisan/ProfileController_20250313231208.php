<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // ...existing code...

    /**
     * Display the artisan profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        // Make sure we're explicitly loading the work experiences relationship
        $workExperiences = $user->artisanProfile->workExperiences()->orderBy('start_date', 'desc')->get();

        // Add this for debugging - it will show in your Laravel log
        \Log::info('Work Experiences loaded: ' . $workExperiences->count());

        return view('artisan.profile', [
            'artisanProfile' => $artisanProfile,
            'workExperiences' => $workExperiences,
        ]);
    }

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
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        // Make sure the is_current field is correctly handled
        $isCurrentJob = $request->boolean('is_current');

        $workExperience = $artisanProfile->workExperiences()->create([
            'title' => $request->title,
            'company' => $request->company,
            'start_date' => $request->start_date,
            'end_date' => $isCurrentJob ? null : $request->end_date,
            'is_current' => $isCurrentJob,
            'description' => $request->description,
        ]);

        // Add this for debugging - it will show in your Laravel log
        \Log::info('Work Experience created: ' . $workExperience->id);

        // Redirect back to profile with success message
        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully!');
    }

    // ...existing code...
}
