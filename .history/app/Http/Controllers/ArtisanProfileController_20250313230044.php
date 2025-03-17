<?php

namespace App\Http\Controllers;

use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArtisanProfileController extends Controller
{
    public function index()
    {
        $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->first();
        $certifications = Certification::where('user_id', Auth::id())->get();
        $workExperiences = WorkExperience::where('user_id', Auth::id())->get();

        return view('artisan.profile', compact('artisanProfile', 'certifications', 'workExperiences'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profession' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            // Add validation for other fields as needed
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle skills as array
        $skills = $request->has('skills') ? explode(',', $request->skills) : [];

        ArtisanProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge(
                $request->except('skills', '_token'),
                ['skills' => $skills]
            )
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function addCertification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'valid_until' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Certification::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'issuer' => $request->issuer,
            'valid_until' => $request->valid_until,
        ]);

        return back()->with('success', 'Certification added successfully.');
    }

    public function addWorkExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        WorkExperience::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->is_current ?? false,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Work experience added successfully.');
    }

    public function deleteCertification($id)
    {
        $certification = Certification::findOrFail($id);

        if ($certification->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $certification->delete();
        return back()->with('success', 'Certification deleted successfully.');
    }

    public function deleteWorkExperience($id)
    {
        $experience = WorkExperience::findOrFail($id);

        if ($experience->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $experience->delete();
        return back()->with('success', 'Work experience deleted successfully.');
    }
}
