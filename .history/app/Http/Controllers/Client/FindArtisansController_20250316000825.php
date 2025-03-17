<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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

        // Get distinct locations for the filter dropdown - ensure the city column exists
        $locations = [];
        if (Schema::hasTable('artisan_profiles') && Schema::hasColumn('artisan_profiles', 'city')) {
            $locations = ArtisanProfile::select('city')
                ->whereNotNull('city')
                ->distinct()
                ->orderBy('city')
                ->pluck('city');
        }

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
            // Check if the table exists first
            if (!Schema::hasTable('artisan_profiles')) {
                Log::warning('artisan_profiles table does not exist');
                return response()->json([
                    'current_page' => 1,
                    'data' => [],
                    'first_page_url' => $request->url() . '?page=1',
                    'from' => null,
                    'last_page' => 1,
                    'last_page_url' => $request->url() . '?page=1',
                    'next_page_url' => null,
                    'path' => $request->url(),
                    'per_page' => 12,
                    'prev_page_url' => null,
                    'to' => null,
                    'total' => 0,
                ]);
            }

            $query = ArtisanProfile::query();

            // Load relationships safely - check if methods exist before calling with()
            $relations = [];
            if (method_exists(ArtisanProfile::class, 'user')) {
                $relations[] = 'user';
            }
            if (method_exists(ArtisanProfile::class, 'category')) {
                $relations[] = 'category';
            }

            if (!empty($relations)) {
                $query->with($relations);
            } else {
                // Fallback if relationships aren't correctly defined
                Log::warning('ArtisanProfile relationships are not properly defined');
            }

            // Apply filters only if the columns exist
            if ($request->filled('search') && (Schema::hasColumn('artisan_profiles', 'name') || Schema::hasColumn('artisan_profiles', 'description'))) {
                $query->where(function ($q) use ($request) {
                    if (Schema::hasColumn('artisan_profiles', 'name')) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    }
                    if (Schema::hasColumn('artisan_profiles', 'description')) {
                        $q->orWhere('description', 'like', '%' . $request->search . '%');
                    }
                });
            }

            if ($request->filled('category') && Schema::hasColumn('artisan_profiles', 'category_id')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('location') && Schema::hasColumn('artisan_profiles', 'city')) {
                $query->where('city', $request->location);
            }

            if ($request->filled('rating') && Schema::hasColumn('artisan_profiles', 'rating')) {
                $query->where('rating', '>=', $request->rating);
            }

            // Use a valid column for ordering - check if rating exists, if not use id
            if (Schema::hasColumn('artisan_profiles', 'rating')) {
                $query->orderBy('rating', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $artisans = $query->paginate(12);

            // Ensure proper user relation in each artisan
            $artisans->through(function ($artisan) {
                // Make sure user relation is available, otherwise create a dummy one
                if (!$artisan->user) {
                    $artisan->user = new User(['name' => 'Unknown Artisan']);
                }
                return $artisan;
            });

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
            Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Failed to fetch artisans: ' . $e->getMessage(),
                'current_page' => 1,
                'data' => [],
                'last_page' => 1,
                'total' => 0
            ], 500);
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
        // Validate request
        $validated = $request->validate([
            'category' => 'nullable|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'skill' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        // Removed the non-existent status column filter
        $query = ArtisanProfile::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where(function (Builder $q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%')
                    ->orWhere('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('skill')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->skill . '%');
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        $artisans = $query->orderBy('rating', 'desc')
            ->paginate(12)
            ->appends($request->except('page'));

        $categories = Category::all();

        return view('client.artisans.search', compact('artisans', 'categories'));
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
