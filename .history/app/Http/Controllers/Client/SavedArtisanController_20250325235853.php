<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\SavedArtisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        
        // Log for debugging
        Log::info('Fetching saved artisans for user: ' . $userId);
        
        // Method 1: Get saved artisans through the User model relationship (preferred)
        $savedArtisans = Auth::user()->savedArtisans()
            ->with(['user', 'reviews', 'certifications', 'services'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
            
        // If the first method returned no results, try alternative method
        if ($savedArtisans->isEmpty()) {
            Log::info('No saved artisans found with method 1, trying method 2');
            
            // Method 2: Get through the pivot model directly
            $savedArtisanIds = SavedArtisan::where('user_id', $userId)
                ->pluck('artisan_profile_id')
                ->toArray();
                
            Log::info('Found saved artisan IDs: ' . implode(', ', $savedArtisanIds));
            
            $savedArtisans = ArtisanProfile::whereIn('id', $savedArtisanIds)
                ->with(['user', 'reviews', 'certifications', 'services'])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->get();
        }
        
        Log::info('Number of saved artisans found: ' . $savedArtisans->count());
        
        return view('client.saved-artisans', compact('savedArtisans'));
    }

    /**
     * Save an artisan to the client's saved list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $artisanProfileId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $artisanProfileId)
    {
        // Check if the artisan profile exists
        $artisanProfile = ArtisanProfile::find($artisanProfileId);

        if (!$artisanProfile) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artisan not found.'
                ]);
            }
            return redirect()->back()->with('error', 'Artisan not found.');
        }

        // Check if the artisan is already saved
        $existingSave = SavedArtisan::where('user_id', Auth::id())
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();

        if ($existingSave) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This artisan is already saved to your list.'
                ]);
            }
            return redirect()->back()->with('info', 'This artisan is already saved to your list.');
        }

        // Save the artisan
        SavedArtisan::create([
            'user_id' => Auth::id(),
            'artisan_profile_id' => $artisanProfileId
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Artisan saved to your list.'
            ]);
        }
        return redirect()->back()->with('success', 'Artisan saved to your list.');
    }

    /**
     * Remove an artisan from the client's saved list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $artisanProfileId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $artisanProfileId)
    {
        // Delete the saved artisan record
        $deleted = SavedArtisan::where('user_id', Auth::id())
            ->where('artisan_profile_id', $artisanProfileId)
            ->delete();

        if ($deleted) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artisan removed from your saved list.'
                ]);
            }
            return redirect()->back()->with('success', 'Artisan removed from your saved list.');
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not remove artisan from your saved list.'
                ]);
            }
            return redirect()->back()->with('error', 'Could not remove artisan from your saved list.');
        }
    }
}
