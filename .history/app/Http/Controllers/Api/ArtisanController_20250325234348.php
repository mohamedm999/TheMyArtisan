<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    /**
     * Save an artisan as a favorite for the current user.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveArtisan($id, Request $request)
    {
        try {
            // Check if the artisan exists
            $artisan = User::whereHas('roles', function($query) {
                $query->where('name', 'artisan');
            })->findOrFail($id);

            $user = Auth::user();

            // Check if already saved
            if ($user->favorites()->where('artisan_id', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This artisan is already in your favorites.'
                ]);
            }

            // Save the artisan as a favorite
            $user->favorites()->create([
                'artisan_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Artisan added to favorites successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving this artisan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove an artisan from the current user's favorites.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsaveArtisan($id, Request $request)
    {
        try {
            $user = Auth::user();

            // Find and delete the favorite
            $deleted = $user->favorites()->where('artisan_id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artisan removed from favorites successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'This artisan is not in your favorites.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing this artisan from favorites.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
