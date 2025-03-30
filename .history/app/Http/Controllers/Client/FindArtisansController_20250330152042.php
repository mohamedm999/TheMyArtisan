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
            
            // Check if status column exists on artisan_profiles table before filtering
            if (Schema::hasColumn('artisan_profiles', 'status')) {
                $query->where('artisan_profiles.status', 'approved');
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

            // Log the SQL query
            Log::info("SQL Query: " . $query->toSql());
            Log::info("Bindings: " . json_encode($query->getBindings()));

            // Count all artisans before paginating
            $totalArtisans = $query->count();
            Log::info("FindArtisansController: Total artisans in database matching filters: {$totalArtisans}");

            // Get paginated results - need to convert back to eloquent for relationships
            $artisanIds = $query->paginate(12, ['artisan_profiles.id'])->pluck('id')->toArray();
            $artisans = ArtisanProfile::with(['user', 'category', 'services', 'reviews'])
                ->withoutGlobalScopes() // Important: disable global scopes
                ->whereIn('id', $artisanIds)
                ->get();

            // Create a custom paginator to maintain pagination info
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $artisans,
                $totalArtisans,
                12,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans matching your search criteria.');
            }

            // Log executed queries
            Log::info('All executed queries: ' . json_encode(DB::getQueryLog()));

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities', 'search', 'category', 'sortBy', 'availability'));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            Log::error('Queries executed: ' . json_encode(DB::getQueryLog()));

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
            
            // Check if status column exists on artisan_profiles table before filtering
            if (Schema::hasColumn('artisan_profiles', 'status')) {
                $query->where('artisan_profiles.status', 'approved');
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
