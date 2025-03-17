<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
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
        try { - wrap in try/catch for better error isolation
            // Get all available categories
            $categories = Category::orderBy('name')->get();                $categories = Category::orderBy('name')->get();
 {
            // Get search parametersories: " . $ce->getMessage());
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest'); // Default sort by newest
            $location = $request->input('location');            // Get search parameters
uest->input('search');
            // Build query
            $sortBy = $request->input('sort', 'newest'); // Default sort by newest 'category'])
            $location = $request->input('location');{
 $q->where('is_active', true);
            // Build base query                });
            $query = ArtisanProfile::query();
            h filter
            // Add relationships with error handling
            try {
                $query->with(['user', 'category']);
                }%")
                // Only filter by active users if the relationship and column exists
                $query->whereHas('user', function ($q) {
                    if (\Schema::hasColumn('users', 'is_active')) { $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");
                        $q->where('is_active', true);     });
                    }   });
                });            }
            } catch (\Exception $re) {
                Log::error("Error with relationships: " . $re->getMessage());y filter
                // Continue with base query if relationship fails
            }nction ($q) use ($category) {
 $q->where('id', $category);
            // Apply search filter with error handling   });
            if ($search) {            }
                try {
                    $query->where(function ($q) use ($search) {n filter
                        // Try each filter separately to prevent one failure from affecting others
                        try {
                            if (\Schema::hasColumn('artisan_profiles', 'profession')) {
                                $q->orWhere('profession', 'like', "%{$search}%");     ->orWhere('country', 'like', "%{$location}%");
                            }   });
                        } catch (\Exception $e) {            }
                            Log::error("Error in profession search: " . $e->getMessage());
                        }

                        try {
                            if (\Schema::hasColumn('artisan_profiles', 'about_me')) {->orderByDesc('rating');
                                $q->orWhere('about_me', 'like', "%{$search}%");
                            }
                        } catch (\Exception $e) {->orderBy('rating');
                            Log::error("Error in about_me search: " . $e->getMessage());
                        }
                        ->orderByDesc('created_at');
                        try {
                            if (\Schema::hasColumn('artisan_profiles', 'skills')) {
                                $q->orWhereJsonContains('skills', $search);->orderBy('created_at');
                            }       break;
                        } catch (\Exception $e) {            }
                            Log::error("Error in skills search: " . $e->getMessage());
                        }nating

                        try {            Log::info("FindArtisansController: Total artisans in database matching filters: {$totalArtisans}");
                            $q->orWhereHas('user', function ($sq) use ($search) {
                                if (\Schema::hasColumn('users', 'firstname') && \Schema::hasColumn('users', 'lastname')) {
                                    $sq->where(\DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");            $artisans = $query->paginate(12)->withQueryString();
                                }
                            });            Log::info("FindArtisansController: Artisans after pagination: {$artisans->count()}");
                        } catch (\Exception $e) {
                            Log::error("Error in user name search: " . $e->getMessage());, add a message to the session
                        }
                    });   session()->flash('info', 'There are currently no artisans matching your search criteria.');
                } catch (\Exception $se) {            }
                    Log::error("Error applying search: " . $se->getMessage());
                }ind-artisans', compact('artisans', 'categories', 'search', 'category', 'sortBy', 'location'));
            }
));
            // Apply category filter with error handlingccurred while loading artisans.');
            if ($category) {
                try {lection
                    $query->whereHas('category', function ($q) use ($category) {warePaginator([], 0, 12),
                        $q->where('id', $category); 'categories' => Category::orderBy('name')->get()
                    });   ]);
                } catch (\Exception $ce) {   }
                    Log::error("Error applying category filter: " . $ce->getMessage());    }
                }
            }
 Get all artisans data for AJAX requests.
            // Apply location filter with error handling
            if ($location) {quest
                try {@return \Illuminate\Http\JsonResponse
                    $query->where(function ($q) use ($location) {
                        if (\Schema::hasColumn('artisan_profiles', 'city')) {ublic function getArtisans(Request $request)
                            $q->orWhere('city', 'like', "%{$location}%");
                        }
                        if (\Schema::hasColumn('artisan_profiles', 'country')) {
                            $q->orWhere('country', 'like', "%{$location}%");
                        }
                    });t');
                } catch (\Exception $le) {            $location = $request->input('location');
                    Log::error("Error applying location filter: " . $le->getMessage());
                }
            } 'category'])
{
            // Apply sorting with error handling $q->where('is_active', true);
            try {                });
                switch ($sortBy) {
                    case 'rating_high':h filter
                        if (\Schema::hasColumn('artisan_profiles', 'rating')) {
                            $query->orderByDesc('rating');
                        } else {
                            $query->orderByDesc('created_at');}%")
                        }
                        break;
                    case 'rating_low': $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");
                        if (\Schema::hasColumn('artisan_profiles', 'rating')) {     });
                            $query->orderBy('rating');   });
                        } else {            }
                            $query->orderBy('created_at');
                        }y filter
                        break;
                    case 'oldest':nction ($q) use ($category) {
                        $query->orderBy('created_at'); $q->where('id', $category);
                        break;   });
                    case 'newest':            }
                    default:
                        $query->orderByDesc('created_at');n filter
                        break;
                }
            } catch (\Exception $se) {
                Log::error("Error applying sorting: " . $se->getMessage());     ->orWhere('country', 'like', "%{$location}%");
                // Default to created_at if sorting fails   });
                $query->orderByDesc('created_at');            }
            }

            // Count and paginate with error handling
            try {
                // Count all artisans before paginating->orderByDesc('rating');
                $totalArtisans = $query->count();
                Log::info("FindArtisansController: Total artisans matching filters: {$totalArtisans}");
                ->orderBy('rating');
                // Get paginated results
                $artisans = $query->paginate(12)->withQueryString();
                Log::info("FindArtisansController: Artisans after pagination: {$artisans->count()}");->orderByDesc('created_at');

                // If there are no artisans, add a message to the session
                if ($artisans->isEmpty()) {->orderBy('created_at');
                    session()->flash('info', 'There are currently no artisans matching your search criteria.');       break;
                }            }
            } catch (\Exception $pe) {
                Log::error("Error during pagination: " . $pe->getMessage());            $artisans = $query->paginate(12);
                throw $pe; // Re-throw to be caught by outer catch
            }ated JSON format for the frontend

            return view('client.find-artisans', compact('artisans', 'categories', 'search', 'category', 'sortBy', 'location'));currentPage(),
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());l(1),
            Log::error("Stack trace: " . $e->getTraceAsString());

            try {>lastPage()),
                $categories = Category::orderBy('name')->get();->nextPageUrl(),
            } catch (\Exception $ce) {
                $categories = collect([]);
            }previousPageUrl(),

            // Create a proper paginator with current page value 'total' => $artisans->total(),
            $currentPage = $request->get('page', 1);
            try {
                $path = $request->url();
                $query = $request->query();   return response()->json(['error' => 'Failed to fetch artisans: ' . $e->getMessage()], 500);
                   }
                // Fix possible errors in the page parameter    }
                if (isset($query['page']) && (!is_numeric($query['page']) || $query['page'] < 1)) {
                    $query['page'] = 1;
                } Display the specified artisan profile.

                $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                    [], // No items@return \Illuminate\Http\Response
                    0,  // Total count
                    12, // Per pageublic function show($id)
                    $currentPage, // Current page
                    ['path' => $path, 'query' => $query]
                );ArtisanProfile::with([
            } catch (\Exception $pe) {
                Log::error("Error creating paginator: " . $pe->getMessage());
                // Fallback to simplest paginator if that fails ($query) {
                $paginator = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12, 1);  $query->latest();
            }
            ser',
            session()->flash('error', 'An error occurred while loading artisans. Please try again later.');
            uery) {
            return view('client.find-artisans', [   $query->latest('start_date');
                'artisans' => $paginator,
                'categories' => $categories,            ])->findOrFail($id);
                'search' => $request->input('search'),
                'category' => $request->input('category'),rtisans.show', compact('artisan'));
                'sortBy' => $request->input('sort', 'newest'),
                'location' => $request->input('location')
            ]);   return redirect()->route('client.find-artisans')->with('error', 'Artisan profile not found.');
        }   }
    }   }
}





















































































































}    }        }            return redirect()->route('client.find-artisans')->with('error', 'Artisan profile not found.');            Log::error("Error showing artisan profile: {$e->getMessage()}");        } catch (\Exception $e) {            return view('client.artisans.show', compact('artisan'));            ])->findOrFail($id);                }                    $query->latest('start_date');                'workExperiences' => function ($query) {                'certifications',                'reviews.client.user',                },                    $query->latest();                'reviews' => function ($query) {                'category',                'user',            $artisan = ArtisanProfile::with([        try {    {    public function show($id)     */     * @return \Illuminate\Http\Response     * @param  int  $id     *     * Display the specified artisan profile.    /**    }        }            return response()->json(['error' => 'Failed to fetch artisans: ' . $e->getMessage()], 500);            Log::error('Error in getArtisans: ' . $e->getMessage());        } catch (\Exception $e) {            ]);                'total' => $artisans->total(),                'to' => $artisans->lastItem(),                'prev_page_url' => $artisans->previousPageUrl(),                'per_page' => $artisans->perPage(),                'path' => $artisans->path(),                'next_page_url' => $artisans->nextPageUrl(),                'last_page_url' => $artisans->url($artisans->lastPage()),                'last_page' => $artisans->lastPage(),                'from' => $artisans->firstItem(),                'first_page_url' => $artisans->url(1),                'data' => $artisans->items(),                'current_page' => $artisans->currentPage(),            return response()->json([            // Return in proper paginated JSON format for the frontend            $artisans = $query->paginate(12);            }                    break;                    $query->orderBy('created_at');                case 'oldest':                    break;                    $query->orderByDesc('created_at');                case 'newest':                    break;                    $query->orderBy('rating');                case 'rating_low':                    break;                    $query->orderByDesc('rating');                case 'rating_high':            switch ($sortBy) {            // Apply sorting            }                });                        ->orWhere('country', 'like', "%{$location}%");                    $q->where('city', 'like', "%{$location}%")                $query->where(function ($q) use ($location) {            if ($location) {            // Apply location filter            }                });                    $q->where('id', $category);                $query->whereHas('category', function ($q) use ($category) {            if ($category) {            // Apply category filter            }                });                        });                            $sq->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");                        ->orWhereHas('user', function ($sq) use ($search) {                        ->orWhereJsonContains('skills', $search)                        ->orWhere('about_me', 'like', "%{$search}%")                    $q->where('profession', 'like', "%{$search}%")                $query->where(function ($q) use ($search) {            if ($search) {            // Apply search filter                });                    $q->where('is_active', true);                ->whereHas('user', function ($q) {            $query = ArtisanProfile::with(['user', 'category'])            // Build query            $location = $request->input('location');            $sortBy = $request->input('sort', 'newest');            $category = $request->input('category');            $search = $request->input('search');            // Get search parameters        try {    {    public function getArtisans(Request $request)     */     * @return \Illuminate\Http\JsonResponse     * @param  \Illuminate\Http\Request  $request     *     * Get all artisans data for AJAX requests.    /**
