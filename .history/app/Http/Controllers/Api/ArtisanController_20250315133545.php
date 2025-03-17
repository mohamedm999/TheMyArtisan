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
        $query = User::where('role', 'artisan');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('specialty', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('specialty', $request->input('category'));
        }

        // Apply location filter
        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        // Apply rating filter
        if ($request->filled('rating')) {
            $minRating = $request->input('rating');
            $query->where('rating', '>=', $minRating);
        }

        // Get artisans with their review count
        $artisans = $query->select([
                'users.*',
                DB::raw('(SELECT COUNT(*) FROM reviews WHERE reviews.artisan_id = users.id) as reviews_count')
            ])
            ->withAvg('reviews', 'rating')
            ->paginate(9);

        // Format the rating properly
        $artisans->getCollection()->transform(function ($artisan) {
            $artisan->rating = $artisan->reviews_avg_rating ?? 0;
            return $artisan;
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
            $artisan = User::where('role', 'artisan')->findOrFail($id);

            // Make sure the user is logged in
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to save artisans.'
                ], 401);
            }

            $user = auth()->user();

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
}
