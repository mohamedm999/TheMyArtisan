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
     * Display a listing of the saved artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $savedArtisans = $user->savedArtisans()
            ->with('user') // Load the artisan's user relationship
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('client.saved-artisans', compact('savedArtisans'));
    }

    /**
     * Save an artisan to the user's saved list.
     *
     * @param  \App\Models\ArtisanProfile  $artisan
     * @return \Illuminate\Http\Response
     */
    public function saveArtisan(ArtisanProfile $artisan)
    {
        $user = Auth::user();
        
        // Check if already saved to prevent duplicates
        $exists = $user->savedArtisans()->where('artisan_profile_id', $artisan->id)->exists();
        
        if (!$exists) {
            $user->savedArtisans()->attach($artisan->id);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artisan saved successfully!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Artisan saved successfully!');
        }
        
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Artisan already saved!'
            ]);
        }
        
        return redirect()->back()->with('info', 'Artisan was already saved.');
    }

    /**
     * Remove an artisan from the user's saved list.
     *
     * @param  \App\Models\ArtisanProfile  $artisan
     * @return \Illuminate\Http\Response
     */
    public function unsaveArtisan(ArtisanProfile $artisan)
    {
        $user = Auth::user();
        $user->savedArtisans()->detach($artisan->id);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Artisan removed from your saved list!'
            ]);
        }
        
        return redirect()->back()->with('success', 'Artisan removed from your saved list!');
    }
}
