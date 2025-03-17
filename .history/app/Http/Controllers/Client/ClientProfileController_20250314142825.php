<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:client');
    }

    public function index()
    {
        $clientProfile = ClientProfile::where('user_id', Auth::id())->first();
        return view('client.profile', compact('clientProfile'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ClientProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['phone', 'address', 'city', 'state', 'postal_code'])
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoName = time() . '_client_profile.' . $profilePhoto->getClientOriginalExtension();
            $profilePhotoPath = $profilePhoto->storeAs('public/clients', $profilePhotoName);

            ClientProfile::updateOrCreate(
                ['user_id' => Auth::id()],
                ['profile_photo' => str_replace('public/', '', $profilePhotoPath)]
            );
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function updatePersonalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user basic info
        Auth::user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ]);

        // Update client profile bio
        ClientProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            ['bio' => $request->bio]
        );

        return back()->with('success', 'Personal information updated successfully.');
    }

    public function updatePreferences(Request $request)
    {
        $preferences = $request->input('preferences', []);

        ClientProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            ['preferences' => $preferences]
        );

        return back()->with('success', 'Preferences updated successfully.');
    }
}
