<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtisanController extends Controller
{
    /**
     * Display a listing of artisans with filtering options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function($query) {
            $query->where('name', 'artisan');
        });

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('firstname', 'like', '%' . $search . '%')
                  ->orWhere('lastname', 'like', '%' . $search . '%')
                  ->orWhereHas('artisanProfile', function($q) use ($search) {
                      $q->where('description', 'like', '%' . $search . '%')
                        ->orWhere('specialty', 'like', '%' . $search . '%');
                  });
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->whereHas('artisanProfile', function($q) use ($request) {
                $q->where('specialty', $request->input('category'));
            });
        }

        // Apply location filter
        if ($request->filled('location')) {
            $query->whereHas('artisanProfile', function($q) use ($request) {
                $q->where('location', $request->input('location'));
            });
        }

        // Apply rating filter
        if ($request->filled('rating')) {
            $minRating = $request->input('rating');
            $query->whereHas('artisanProfile', function($q) use ($minRating) {
                $q->where('rating', '>=', $minRating);
            });
        }

        // Get artisans with their profile and review count
        $artisans = $query->with(['artisanProfile'])
            ->select([
                'users.*',
                DB::raw('(SELECT COUNT(*) FROM reviews WHERE reviews.artisan_id = users.id) as reviews_count')
            ])
            ->paginate(9);

        // Format the response data
        $artisans->getCollection()->transform(function ($user) {
            $profile = $user->artisanProfile;
            return [
                'id' => $user->id,
                'name' => $user->firstname . ' ' . $user->lastname,
                'specialty' => $profile ? $profile->specialty : '',
                'location' => $profile ? $profile->location : '',
                'description' => $profile ? $profile->description : '',
                'rating' => $profile ? $profile->rating : 0,
                'reviews_count' => $user->reviews_count ?? 0
            ];
        });

        return response()->json(['artisans' => $artisans]);
    }

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

            // Make sure the user is logged in
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to save artisans.'
                ], 401);
            }

            $user = auth()->user();

            // Check if already saved (assuming you have a favorites relationship)
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
}
