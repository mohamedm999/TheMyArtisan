<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
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
        // Log the raw SQL queries for debugging
        DB::enableQueryLog();

        try {
            // Get all available categories, countries and cities for filters
            $categories = Category::orderBy('name')->get();
            $countries = Country::orderBy('name')->get();
            $cities = City::orderBy('name')->get();

            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest'); // Default sort by newest
            $location = $request->input('location');
            $availability = $request->input('availability', 'all');

            // Build query with eager loading - use a raw query approach to avoid scope/global scope issues
            $query = ArtisanProfile::with(['user', 'category', 'services', 'reviews']);

            // Use a direct join approach instead of whereHas which might include scopes
            $query->join('users', 'artisan_profiles.user_id', '=', 'users.id')
                  ->join('role_user', 'users.id', '=', 'role_user.user_id')
                  ->join('roles', 'roles.id', '=', 'role_user.role_id')
                  ->where('users.is_active', true)
                  ->where(function($q) {
                      $q->where('roles.name', 'artisan')
                        ->orWhere('roles.name', 'Artisan');
                  })
                  ->select('artisan_profiles.*'); // Important to select only from artisan_profiles

            // Add status check on users if column exists
            if (Schema::hasColumn('users', 'status')) {
                $query->where('users.status', 'active');
            }

            // Apply availability filter - only if is_available column exists
            if ($availability === 'available' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $query->where('artisan_profiles.is_available', true);
            } elseif ($availability === 'unavailable' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $query->where('artisan_profiles.is_available', false);
            }

            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('artisan_profiles.profession', 'like', "%{$search}%")
                      ->orWhere('artisan_profiles.about_me', 'like', "%{$search}%")
                      ->orWhereJsonContains('artisan_profiles.skills', $search)
                      ->orWhere(DB::raw("CONCAT(users.firstname, ' ', users.lastname)"), 'like', "%{$search}%");
                });
            }

            // Apply category filter
            if ($category) {
                $query->where('artisan_profiles.category_id', $category);
            }

            // Apply location filter
            if ($location) {
                $query->where(function ($q) use ($location) {
                    $q->where('artisan_profiles.city', 'like', "%{$location}%")
                      ->orWhere('artisan_profiles.country', 'like', "%{$location}%");
                });
            }

            // Apply sorting
            switch ($sortBy) {
                case 'rating_high':
                    $query->orderByDesc('artisan_profiles.rating');
                    break;
                case 'rating_low':
                    $query->orderBy('artisan_profiles.rating');
                    break;
                case 'newest':
                    $query->orderByDesc('artisan_profiles.created_at');
                    break;
                case 'oldest':
                    $query->orderBy('artisan_profiles.created_at');
                    break;
            }

            // Log the query being executed
            Log::info("Query: " . $query->toSql());
            Log::info("Bindings: " . json_encode($query->getBindings()));

            // Get distinct results to prevent duplicates from joins
            $query->distinct();

            // Get paginated results
            $artisans = $query->paginate(12)->withQueryString();

            // Log executed queries
            Log::info('SQL Queries: ' . json_encode(DB::getQueryLog()));

            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans matching your search criteria.');
            }

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities', 'search', 'category', 'sortBy', 'availability'));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            Log::info('SQL Queries that failed: ' . json_encode(DB::getQueryLog()));

            session()->flash('error', 'An error occurred while loading artisans.');
            return view('client.artisans.index', [
                'artisans' => ArtisanProfile::where('id', 0)->paginate(12),
                'categories' => Category::orderBy('name')->get(),
                'countries' => Country::orderBy('name')->get(),
                'cities' => City::orderBy('name')->get(),
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'sortBy' => $request->input('sort', 'newest'),
                'availability' => $request->input('availability', 'all')
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
            $availability = $request->input('availability', 'all');

            // Build query
            $query = ArtisanProfile::with(['user', 'category'])
                ->whereHas('user', function ($q) {
                    $q->where('is_active', true);
                    // Only check status on users table if it exists
                    if (Schema::hasColumn('users', 'status')) {
                        $q->where('status', 'active');
                    }
                });

            // Check if the user is an artisan
            $query->whereHas('user.roles', function ($q) {
                $q->where('name', 'artisan')
                    ->orWhere('name', 'Artisan');
            });

            // Apply availability filter - only if is_available column exists
            if ($availability === 'available' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $query->where('is_available', true);
            } elseif ($availability === 'unavailable' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $query->where('is_available', false);
            }

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
