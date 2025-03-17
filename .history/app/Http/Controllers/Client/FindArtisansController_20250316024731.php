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
     * Display a listing of all artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            Log::info("FindArtisansController: Starting index method");
            
            // Log current artisans count
            $totalAllArtisans = ArtisanProfile::count();
            Log::info("Total artisans in database (unfiltered): {$totalAllArtisans}");
            
            // Get categories with error handling
            try {
                $categories = Category::orderBy('name')->get();
                Log::info("Categories loaded: {$categories->count()}");
            } catch (\Exception $e) {
                Log::error("Error loading categories: {$e->getMessage()}");
                $categories = collect([]);
            }

            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest');
            $location = $request->input('location');
            
            Log::info("Search parameters:", [
                'search' => $search,
                'category' => $category,
                'sortBy' => $sortBy,
                'location' => $location
            ]);

            // Build base query - start without any filtering to diagnose issues
            $query = ArtisanProfile::query();
            
            // Add relationships only if they definitely exist
            try {
                $query->with(['user', 'category']);
            } catch (\Exception $e) {
                Log::warning("Error adding relationships: {$e->getMessage()}");
            }
            
            // IMPORTANT: Instead of filtering by is_active, let's get all artisans first
            // We can uncomment this later when we confirm artisans are displaying
            /*
            if (Schema::hasColumn('users', 'is_active')) {
                $query->whereHas('user', function ($q) {
                    $q->where('is_active', true);
                });
            }
            */
            
            // Apply search filter with error handling
            if ($search) {
                try {
                    $query->where(function ($q) use ($search) {
                        $q->orWhere('profession', 'like', "%{$search}%")
                          ->orWhere('about_me', 'like', "%{$search}%");
                          
                        // Only use JSON search if skills column is of JSON type
                        if (Schema::hasColumn('artisan_profiles', 'skills')) {
                            try {
                                $q->orWhereJsonContains('skills', $search);
                            } catch (\Exception $e) {
                                Log::warning("JSON search failed: {$e->getMessage()}");
                            }
                        }
                        
                        // Search in user name if the relationship works
                        try {
                            $q->orWhereHas('user', function ($sq) use ($search) {
                                $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%")
                                   ->orWhere('firstname', 'like', "%{$search}%")
                                   ->orWhere('lastname', 'like', "%{$search}%");
                            });
                        } catch (\Exception $e) {
                            Log::warning("User name search failed: {$e->getMessage()}");
                        }
                    });
                } catch (\Exception $e) {
                    Log::error("Search filter error: {$e->getMessage()}");
                }
            }

            // Apply category filter
            if ($category) {
                try {
                    $query->where('category_id', $category);
                } catch (\Exception $e) {
                    Log::warning("Category filter error: {$e->getMessage()}");
                }
            }

            // Apply location filter
            if ($location) {
                try {
                    $query->where(function ($q) use ($location) {
                        $q->where('city', 'like', "%{$location}%")
                          ->orWhere('country', 'like', "%{$location}%");
                    });
                } catch (\Exception $e) {
                    Log::warning("Location filter error: {$e->getMessage()}");
                }
            }

            // Apply sorting
            try {
                switch ($sortBy) {
                    case 'rating_high':
                        $query->orderByDesc('rating');
                        break;
                    case 'rating_low':
                        $query->orderBy('rating');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at');
                        break;
                    case 'newest':
                    default:
                        $query->orderByDesc('created_at');
                        break;
                }
            } catch (\Exception $e) {
                Log::warning("Sorting error: {$e->getMessage()}");
                $query->orderByDesc('id'); // Fallback sort
            }

            // Get filtered count before pagination
            try {
                $totalFilteredArtisans = $query->count();
                Log::info("Filtered artisans count: {$totalFilteredArtisans}");
            } catch (\Exception $e) {
                Log::error("Error counting filtered artisans: {$e->getMessage()}");
                $totalFilteredArtisans = 0;
            }
            
            // Show the SQL query for debugging
            $querySql = $query->toSql();
            $queryBindings = $query->getBindings();
            Log::info("Query SQL: {$querySql}", ['bindings' => $queryBindings]);
            
            // Get paginated results
            $artisans = $query->paginate(12)->withQueryString();
            Log::info("Artisans after pagination: {$artisans->count()} of {$artisans->total()}");
            
            // Log the first few artisans for debugging
            if ($artisans->count() > 0) {
                $sample = $artisans->take(3)->map(function($item) {
                    return [
                        'id' => $item->id,
                        'user_id' => $item->user_id, 
                        'profession' => $item->profession,
                        'has_user' => isset($item->user)
                    ];
                });
                Log::info("Sample artisans: " . json_encode($sample));
            }

            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans matching your search criteria.');
            }

            return view('client.find-artisans', compact(
                'artisans', 
                'categories', 
                'search', 
                'category', 
                'sortBy', 
                'location',
                'totalAllArtisans',
                'totalFilteredArtisans'
            ));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            session()->flash('error', 'An error occurred while loading artisans: ' . $e->getMessage());
            
            // Create an empty paginator
            $currentPage = $request->get('page', 1);
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                [], 
                0, 
                12, 
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            // Get categories for the form
            try {
                $categories = Category::orderBy('name')->get();
            } catch (\Exception $ce) {
                $categories = collect([]);
            }
            
            return view('client.find-artisans', [
                'artisans' => $paginator,
                'categories' => $categories,
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'sortBy' => $request->input('sort', 'newest'),
                'location' => $request->input('location'),
                'totalAllArtisans' => 0,
                'totalFilteredArtisans' => 0
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
