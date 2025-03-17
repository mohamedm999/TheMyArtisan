<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class FindArtisansController extends Controller
{
    /**
     * Display a listing of the artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        // Get distinct locations for the filter dropdown
        // Removed the non-existent status column filter
        $locations = ArtisanProfile::select('city')
            ->whereNotNull('city') // Only include records with a city
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('client.find-artisans', compact('categories', 'locations'));
    }

    /**
     * Get artisans data for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArtisans(Request $request)
    {
        try {
            $query = ArtisanProfile::query();

            // Make sure the relationships exist before using them
            if (method_exists(ArtisanProfile::class, 'user') && method_exists(ArtisanProfile::class, 'category')) {
                $query->with(['user', 'category']);
            }

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('location')) {
                $query->where('city', $request->location);
            }

            if ($request->filled('rating')) {
                $query->where('rating', '>=', $request->rating);
            }

            $artisans = $query->orderBy('created_at', 'desc') // Use a fallback sorting if rating doesn't exist
                ->paginate(12);

            // Return in proper paginated JSON format for the frontend
            return response()->json([
                'current_page' => $artisans->currentPage(),
                'data' => $artisans->items(),
                'first_page_url' => $artisans->url(1),
                'from' => $artisans->firstItem(),
                'last_page' => $artisans->lastPage(),
                'last_page_url' => $artisans->url($artisans->lastPage()),
                'next_page_url' => $artisans->nextPageUrl(),
                'path' => $artisans->path(),
                'per_page' => $artisans->perPage(),
                'prev_page_url' => $artisans->previousPageUrl(),
                'to' => $artisans->lastItem(),
                'total' => $artisans->total(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getArtisans: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch artisans: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Search for artisans based on filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'category' => 'nullable|exists:categories,id',
                'location' => 'nullable|string|max:255',
                'skill' => 'nullable|string|max:255',
                'rating' => 'nullable|integer|min:1|max:5',
                'search' => 'nullable|string|max:255'
            ]);

            $query = ArtisanProfile::query();
            
            // Eager load relationships for better performance
            $query->with(['user', 'category', 'skills']);
            
            // General search term
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            // Category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Location filter
            if ($request->filled('location')) {
                $query->where(function (Builder $q) use ($request) {
                    $q->where('location', 'like', '%' . $request->location . '%')
                      ->orWhere('city', 'like', '%' . $request->location . '%')
                      ->orWhere('state', 'like', '%' . $request->location . '%');
                });
            }

            // Skills filter
            if ($request->filled('skill')) {
                $query->whereHas('skills', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->skill . '%');
                });
            }

            // Rating filter
            if ($request->filled('rating')) {
                $query->where('rating', '>=', $request->rating);
            }

            // Get results with pagination
            $artisans = $query->orderBy('rating', 'desc')
                ->paginate(12)
                ->appends($request->except('page'));

            $categories = Category::all();

            return view('client.artisans.search', compact('artisans', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in search method: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while searching for artisans. Please try again.');
        }
    }

    /**
     * Display the specified artisan profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = ArtisanProfile::with(['skills', 'reviews', 'portfolio'])
            ->findOrFail($id);
        return view('client.artisans.show', compact('artisan'));
    }
}
