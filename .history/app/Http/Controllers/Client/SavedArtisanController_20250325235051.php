<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\SavedArtisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedArtisanController extends Controller
{
    /**
     * Display the client's saved artisans.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the current user's ID
        $userId = Auth::id();

        // Retrieve the saved artisan profiles with their related user data, including reviews
        $savedArtisans = ArtisanProfile::whereHas('savedByUsers', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['user', 'reviews'])
        ->withCount('reviews')
        ->withAvg('reviews', 'rating')
        ->get();

        return view('client.saved-artisans', compact('savedArtisans'));
    }

    /**
     * Save an artisan to the client's saved list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $artisanProfileId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $artisanProfileId)
    {
        // Check if the artisan profile exists
        $artisanProfile = ArtisanProfile::find($artisanProfileId);

        if (!$artisanProfile) {
            return redirect()->back()->with('error', 'Artisan not found.');
        }

        // Check if the artisan is already saved
        $existingSave = SavedArtisan::where('user_id', Auth::id())
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();

        if ($existingSave) {
            return redirect()->back()->with('info', 'This artisan is already saved to your list.');
        }

        // Save the artisan
        SavedArtisan::create([
            'user_id' => Auth::id(),
            'artisan_profile_id' => $artisanProfileId
        ]);

        return redirect()->back()->with('success', 'Artisan saved to your list.');
    }

    /**
     * Remove an artisan from the client's saved list.
     *
     * @param  int  $artisanProfileId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($artisanProfileId)
    {
        // Delete the saved artisan record
        $deleted = SavedArtisan::where('user_id', Auth::id())
            ->where('artisan_profile_id', $artisanProfileId)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Artisan removed from your saved list.');
        } else {
            return redirect()->back()->with('error', 'Could not remove artisan from your saved list.');
        }
    }
}
