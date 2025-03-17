<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkExperience;
use App\Models\Certification;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{
    /**
     * Display the artisan profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $workExperiences = WorkExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $certifications = Certification::where('user_id', $user->id)->get();

        return view('artisan.profile', compact('workExperiences', 'certifications'));
    }

    /**
     * Update the artisan's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle photo upload logic here
        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/profile_photos', $filename);

            $user->profile_photo = $filename;
            $user->save();
        }

        return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully');
    }

    /**
     * Update the artisan's professional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfessionalInfo(Request $request)
    {
        $request->validate([
            'profession' => 'required|string|max:255',
            'about_me' => 'required|string',
            'skills' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->profession = $request->profession;
        $user->about_me = $request->about_me;
        $user->skills = json_encode(explode(',', $request->skills));
        $user->save();

        return redirect()->route('artisan.profile')->with('success', 'Professional information updated successfully');
    }

    /**
     * Store a new work experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWorkExperience(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'required|string',
        ]);

        WorkExperience::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'company' => $request->company,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_current' => $request->has('is_current'),
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully');
    }

    /**
     * Store a new certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCertification(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'valid_until' => 'required|date',
        ]);

        Certification::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'issuer' => $request->issuer,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Certification added successfully');
    }
}
