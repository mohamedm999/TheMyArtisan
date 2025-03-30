<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            // Enable query logging to debug the SQL
            DB::enableQueryLog();

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

            // IMPORTANT: Use raw DB query to completely bypass Eloquent and any scopes
            $rawQuery = "SELECT DISTINCT ap.* FROM artisan_profiles ap
                JOIN users u ON ap.user_id = u.id
                JOIN role_user ru ON u.id = ru.user_id
                JOIN roles r ON ru.role_id = r.id
                WHERE u.is_active = 1
                AND (r.name = 'artisan' OR r.name = 'Artisan')";
                
            // Add status check on users if the column exists
            if (Schema::hasColumn('users', 'status')) {
                $rawQuery .= " AND u.status = 'active'";
            }
            
            // Build parameter array for the raw query
            $queryParams = [];
            
            // Apply search filter
            if ($search) {
                $rawQuery .= " AND (ap.profession LIKE ? OR ap.about_me LIKE ? OR CONCAT(u.firstname, ' ', u.lastname) LIKE ?)";
                $queryParams[] = "%{$search}%";
                $queryParams[] = "%{$search}%";
                $queryParams[] = "%{$search}%";
            }
            
            // Apply category filter
            if ($category) {
                $rawQuery .= " AND ap.category_id = ?";
                $queryParams[] = $category;
            }
            
            // Apply location filter
            if ($location) {
                $rawQuery .= " AND (ap.city LIKE ? OR ap.country LIKE ?)";
                $queryParams[] = "%{$location}%";
                $queryParams[] = "%{$location}%";
            }
            
            // Apply availability filter
            if ($availability === 'available' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $rawQuery .= " AND ap.is_available = 1";
            } elseif ($availability === 'unavailable' && Schema::hasColumn('artisan_profiles', 'is_available')) {
                $rawQuery .= " AND ap.is_available = 0";
            }
            
            // Apply sorting
            switch ($sortBy) {
                case 'rating_high':
                    $rawQuery .= " ORDER BY ap.rating DESC";
                    break;
                case 'rating_low':
                    $rawQuery .= " ORDER BY ap.rating ASC";
                    break;
                case 'newest':
                    $rawQuery .= " ORDER BY ap.created_at DESC";
                    break;
                case 'oldest':
                    $rawQuery .= " ORDER BY ap.created_at ASC";
                    break;
                default:
                    $rawQuery .= " ORDER BY ap.created_at DESC";
            }
            
            // Log what we're about to execute
            Log::info("Raw SQL Query: " . $rawQuery);
            Log::info("Query Params: " . json_encode($queryParams));
            
            // Get the total count for pagination
            $countQuery = "SELECT COUNT(DISTINCT ap.id) as total FROM (" . $rawQuery . ") as ap";
            $totalCount = DB::selectOne($countQuery, $queryParams);
                
            $totalArtisans = $totalCount ? $totalCount->total : 0;
            
            // Calculate pagination variables
            $perPage = 12;
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $perPage;
            
            // Add pagination to the query
            $rawQuery .= " LIMIT ? OFFSET ?";
            $queryParams[] = $perPage;
            $queryParams[] = $offset;
            
            // Execute the query
            $artisanResults = DB::select($rawQuery, $queryParams);
            
            // Get IDs of the results
            $artisanIds = array_column($artisanResults, 'id');
            
            // If we have results, load them with Eloquent but carefully avoid global scopes
            if (!empty($artisanIds)) {
                // Use select raw to force a direct query with no conditions
                DB::statement("SET SQL_MODE=''");
                $artisans = DB::table('artisan_profiles')
                    ->whereIn('id', $artisanIds)
                    ->get();
                    
                // Log the results
                Log::info("Artisans found: " . count($artisans));
                
                // Convert to collection to make it compatible with the view
                $artisans = collect($artisans);
                
                // We need to add relationships manually
                $userIds = $artisans->pluck('user_id')->toArray();
                $users = DB::table('users')->whereIn('id', $userIds)->get()->keyBy('id');
                $categoryIds = $artisans->pluck('category_id')->filter()->toArray();
                $categories = DB::table('categories')->whereIn('id', $categoryIds)->get()->keyBy('id');
                
                // Add services
                $services = DB::table('services')
                    ->whereIn('artisan_profiles_id', $artisanIds)
                    ->orWhereIn('artisan_id', $artisanIds)
                    ->get()
                    ->groupBy(function($service) {
                        return $service->artisan_profiles_id ?: $service->artisan_id;
                    });
                    
                // Add reviews
                $reviews = DB::table('reviews')
                    ->whereIn('artisan_id', $artisanIds)
                    ->get()
                    ->groupBy('artisan_id');
                
                // Attach relationships to each artisan
                foreach ($artisans as $key => $artisan) {
                    // Add user
                    $artisan->user = $users->get($artisan->user_id);
                    
                    // Add category
                    if ($artisan->category_id && isset($categories[$artisan->category_id])) {
                        $artisan->category = $categories[$artisan->category_id];
                    }
                    
                    // Add services
                    $artisan->services = $services->get($artisan->id, collect());
                    
                    // Add reviews
                    $artisanReviews = $reviews->get($artisan->id, collect());
                    $artisan->reviews = $artisanReviews;
                    $artisan->reviews_count = $artisanReviews ? count($artisanReviews) : 0;
                    
                    // Add computed fields needed by the view
                    if ($artisan->reviews_count > 0) {
                        $artisan->reviews_avg_rating = $artisanReviews->avg('rating');
                    } else {
                        $artisan->reviews_avg_rating = 0;
                    }
                }
            } else {
                $artisans = collect();
            }
            
            // Create a custom paginator
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $artisans,
                $totalArtisans,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            // Log executed queries
            Log::info('All executed queries: ' . json_encode(DB::getQueryLog()));
            
            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans matching your search criteria.');
            }

            return view('client.artisans.index', [
                'artisans' => $paginator,
                'categories' => $categories,
                'countries' => $countries,
                'cities' => $cities,
                'search' => $search,
                'category' => $category,
                'sortBy' => $sortBy,
                'availability' => $availability
            ]);
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            Log::error('Queries executed: ' . json_encode(DB::getQueryLog()));

            session()->flash('error', 'An error occurred while loading artisans: ' . $e->getMessage());
            
            return view('client.artisans.index', [
                'artisans' => collect([]),
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
            // Enable query logging
            DB::enableQueryLog();

            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest');
            $location = $request->input('location');
            $availability = $request->input('availability', 'all');

            // Use the query builder directly to bypass global scopes
            $query = DB::table('artisan_profiles')
                ->join('users', 'artisan_profiles.user_id', '=', 'users.id')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.is_active', true)
                ->where(function ($q) {
                    $q->where('roles.name', 'artisan')
                        ->orWhere('roles.name', 'Artisan');
                });

            // Only check status on users table if it exists
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

            // Select only the artisan profiles columns
            $query->select('artisan_profiles.*')->distinct();

            // Count total for pagination
            $total = $query->count();

            // Get paginated results
            $perPage = 12;
            $page = $request->input('page', 1);
            $artisanIds = $query->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->pluck('artisan_profiles.id')
                ->toArray();

            // Get the actual artisans with their relationships
            $artisans = ArtisanProfile::with(['user', 'category'])
                ->withoutGlobalScopes() // Important: disable global scopes
                ->whereIn('id', $artisanIds)
                ->get();

            // Log queries
            Log::info('AJAX queries: ' . json_encode(DB::getQueryLog()));

            // Return in proper paginated JSON format for the frontend
            return response()->json([
                'current_page' => (int)$page,
                'data' => $artisans,
                'first_page_url' => url()->current() . '?page=1',
                'from' => ($page - 1) * $perPage + 1,
                'last_page' => ceil($total / $perPage),
                'last_page_url' => url()->current() . '?page=' . ceil($total / $perPage),
                'next_page_url' => $page < ceil($total / $perPage) ? url()->current() . '?page=' . ($page + 1) : null,
                'path' => url()->current(),
                'per_page' => $perPage,
                'prev_page_url' => $page > 1 ? url()->current() . '?page=' . ($page - 1) : null,
                'to' => min($page * $perPage, $total),
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getArtisans: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Queries executed: ' . json_encode(DB::getQueryLog()));

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
            // Use withoutGlobalScopes to prevent the status filter
            $artisan = ArtisanProfile::withoutGlobalScopes()->with([
                'user',
                'category',
                'reviews' => function ($query) {
                    $query->latest();
                },
                'reviews.client.user',
                'certifications',
                'workExperiences' => function ($query) {
                    $query->latest('start_date');
                },
                'services'
            ])->findOrFail($id);

            return view('client.artisans.show', compact('artisan'));
        } catch (\Exception $e) {
            Log::error("Error showing artisan profile: {$e->getMessage()}");
            return redirect()->route('client.find-artisans')->with('error', 'Artisan profile not found.');
        }
    }
}
