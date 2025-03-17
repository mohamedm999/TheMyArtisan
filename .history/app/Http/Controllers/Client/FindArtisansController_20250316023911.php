<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FindArtisansController extends Controller
{
    /**
     * Display a listing of all artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Get all available categories
            $categories = Category::orderBy('name')->get();

            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest'); // Default sort by newest
            $location = $request->input('location');

            // Build query with safer relationship checks
            $query = ArtisanProfile::query();

            // Add relationships only if they exist (using with to avoid errors)
            $with = [];
            if (method_exists(ArtisanProfile::class, 'user')) $with[] = 'user';
            if (method_exists(ArtisanProfile::class, 'category')) $with[] = 'category';

            if (!empty($with)) {
                $query->with($with);
            }

            // Safer user relationship check
            if (method_exists(ArtisanProfile::class, 'user')) {
                $query->whereHas('user', function ($q) {
                    if (Schema::hasColumn('users', 'is_active')) {
                        $q->where('is_active', true);
                    }
                });
            }

            // Apply search filter with safer checks
            if ($search) {
                $query->where(function ($q) use ($search) {
                    // Only add these conditions if the columns exist
                    if (Schema::hasColumn('artisan_profiles', 'profession')) {
                        $q->orWhere('profession', 'like', "%{$search}%");
                    }

                    if (Schema::hasColumn('artisan_profiles', 'about_me')) {
                        $q->orWhere('about_me', 'like', "%{$search}%");
                    }

                    // Only use JSON contains if the column is of JSON type
                    if (Schema::hasColumn('artisan_profiles', 'skills')) {
                        try {
                            $q->orWhereJsonContains('skills', $search);
                        } catch (\Exception $e) {
                            Log::warning("JSON search failed: {$e->getMessage()}");
                        }
                    }

                    // Safer user relationship searching
                    if (method_exists(ArtisanProfile::class, 'user')) {
                        $q->orWhereHas('user', function ($sq) use ($search) {
                            // Check if these columns exist
                            if (Schema::hasColumn('users', 'firstname') && Schema::hasColumn('users', 'lastname')) {
                                $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");
                            } elseif (Schema::hasColumn('users', 'name')) {
                                $sq->where('name', 'like', "%{$search}%");
                            }
                        });
                    }
                });
            }

            // Apply category filter with safer checks
            if ($category && method_exists(ArtisanProfile::class, 'category')) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('id', $category);
                });
            }

            // Apply location filter with safer checks
            if ($location) {
                $query->where(function ($q) use ($location) {
                    if (Schema::hasColumn('artisan_profiles', 'city')) {
                        $q->orWhere('city', 'like', "%{$location}%");
                    }

                    if (Schema::hasColumn('artisan_profiles', 'country')) {
                        $q->orWhere('country', 'like', "%{$location}%");
                    }
                });
            }

            // Apply sorting with safer checks
            switch ($sortBy) {
                case 'rating_high':
                    if (Schema::hasColumn('artisan_profiles', 'rating')) {
                        $query->orderByDesc('rating');
                    } else {
                        $query->orderByDesc('created_at'); // Fallback
                    }
                    break;
                case 'rating_low':
                    if (Schema::hasColumn('artisan_profiles', 'rating')) {
                        $query->orderBy('rating');
                    } else {
                        $query->orderBy('created_at'); // Fallback
                    }
                    break;
                case 'oldest':
                    $query->orderBy('created_at');
                    break;
                case 'newest':
                default:
                    $query->orderByDesc('created_at');
                    break;
            }

            // Get paginated results
            $artisans = $query->paginate(12)->withQueryString();

            Log::info("FindArtisansController: Artisans after pagination: {$artisans->count()}");

            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans matching your search criteria.');
            }

            return view('client.find-artisans', compact('artisans', 'categories', 'search', 'category', 'sortBy', 'location'));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            // Create an empty paginator correctly with the current page
            $currentPage = $request->get('page', 1);
            $emptyPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                [], // No items
                0,  // Total count of zero
                12, // Per page
                $currentPage, // Current page
                ['path' => $request->url(), 'query' => $request->query()] // Maintain query string parameters
            );

            // Get categories - handle potential errors here too
            try {
                $categories = Category::orderBy('name')->get();
            } catch (\Exception $catEx) {
                Log::error("Failed to get categories: " . $catEx->getMessage());
                $categories = collect([]);
            }

            session()->flash('error', 'An error occurred while loading artisans. Details: ' . $e->getMessage());

            return view('client.find-artisans', [
                'artisans' => $emptyPaginator,
                'categories' => $categories,
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'sortBy' => $request->input('sort', 'newest'),
                'location' => $request->input('location')
            ]);
        }
    }

    /**
     * Get all artisans data for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArtisans(Request $request)
    {
        try {
            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest');
            $location = $request->input('location');

            // Build query
            $query = ArtisanProfile::with(['user', 'category'])
                ->whereHas('user', function ($q) {
                    $q->where('is_active', true);
                });

            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('profession', 'like', "%{$search}%")
                        ->orWhere('about_me', 'like', "%{$search}%")
                        ->orWhereJsonContains('skills', $search)
                        ->orWhereHas('user', function ($sq) use ($search) {
                            $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");
                        });
                });
            }

            // Apply category filter
            if ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('id', $category);
                });
            }

            // Apply location filter
            if ($location) {
                $query->where(function ($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                        ->orWhere('country', 'like', "%{$location}%");
                });
            }

            // Apply sorting
            switch ($sortBy) {
                case 'rating_high':
                    $query->orderByDesc('rating');
                    break;
                case 'rating_low':
                    $query->orderBy('rating');
                    break;
                case 'newest':
                    $query->orderByDesc('created_at');
                    break;
                case 'oldest':
                    $query->orderBy('created_at');
                    break;
            }

            $artisans = $query->paginate(12);

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
     * Display the specified artisan profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $artisan = ArtisanProfile::with([
                'user',
                'category',
                'reviews' => function ($query) {
                    $query->latest();
                },
                'reviews.client.user',
                'certifications',
                'workExperiences' => function ($query) {
                    $query->latest('start_date');
                }
            ])->findOrFail($id);

            return view('client.artisans.show', compact('artisan'));
        } catch (\Exception $e) {
            Log::error("Error showing artisan profile: {$e->getMessage()}");
            return redirect()->route('client.find-artisans')->with('error', 'Artisan profile not found.');
        }
    }
}
