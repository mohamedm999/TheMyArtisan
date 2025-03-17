<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\;
use App\Models\SavedArtisan;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    /**
     * Display the find artisans page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.find-artisans');
    }

    /**
     * API endpoint to fetch artisans based on filters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArtisans(Request $request)
    {
        $query = Artisan::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('specialty', $request->category);
        }

        // Apply location filter
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', $request->location);
        }

        // Apply rating filter
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', '>=', $request->rating);
        }

        // Get paginated results
        $artisans = $query->withCount('reviews')
                         ->orderBy('rating', 'desc')
                         ->paginate(9);

        return response()->json([
            'artisans' => $artisans
        ]);
    }

    /**
     * API endpoint to save an artisan to favorites
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveArtisan(Request $request, $id)
    {
        try {
            // Check if artisan exists
            $artisan = Artisan::findOrFail($id);

            // Check if already saved
            $saved = SavedArtisan::where('user_id', Auth::id())
                               ->where('artisan_id', $id)
                               ->exists();

            if ($saved) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artisan already in your favorites'
                ]);
            }

            // Save the artisan
            SavedArtisan::create([
                'user_id' => Auth::id(),
                'artisan_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Artisan saved to favorites'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save artisan'
            ], 500);
        }
    }
}
