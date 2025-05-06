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
            } catch (\Exception $ce) {
                Log::error("Error loading categories: " . $ce->getMessage());
                $categories = collect([]);
            }

            // Get search parameters
            $search = $request->input('search');
            $category = $request->input('category');
            $sortBy = $request->input('sort', 'newest'); // Default sort by newest
            $location = $request->input('location');
            $availability = $request->input('availability', 'all'); // Default to all

            // Build query
            $query = ArtisanProfile::with(['user', 'category'])
                ->whereHas('user', function ($q) {
                    $q->where('status', 'active');
                })
                ->where('status', 'approved');

            // Apply search filter if provided
            if ($search) {
                Log::info("Applying search filter: {$search}");
                $query->where(function($q) use ($search) {
                    $q->where('profession', 'like', "%{$search}%")
                      ->orWhere('about_me', 'like', "%{$search}%")
                      ->orWhereHas('user', function($uq) use ($search) {
                          $uq->where('firstname', 'like', "%{$search}%")
                             ->orWhere('lastname', 'like', "%{$search}%");
                      });
                });
            }

            // Apply category filter if provided
            if ($category) {
                Log::info("Applying category filter: {$category}");
                $query->whereHas('category', function($q) use ($category) {
                    $q->where('categories.id', $category);
                });
            }

            // Apply location filter if provided
            if ($location) {
                Log::info("Applying location filter: {$location}");
                $query->where(function($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                      ->orWhere('country', 'like', "%{$location}%");
                });
            }

            // Apply availability filter if provided and not 'all'
            if ($availability && $availability !== 'all') {
                Log::info("Applying availability filter: {$availability}");
                $query->whereHas('availabilities', function($q) use ($availability) {
                    if ($availability === 'available') {
                        $q->where('status', 'available');
                    } elseif ($availability === 'today') {
                        $q->whereDate('date', now()->toDateString())
                          ->where('status', 'available');
                    } elseif ($availability === 'this_week') {
                        $q->whereBetween('date', [
                            now()->startOfWeek()->toDateString(),
                            now()->endOfWeek()->toDateString()
                        ])->where('status', 'available');
                    }
                });
            }

            // Apply sorting
            switch ($sortBy) {
                case 'rating':
                    Log::info("Sorting by rating");
                    $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                    break;
                case 'reviews':
                    Log::info("Sorting by review count");
                    $query->withCount('reviews')->orderByDesc('reviews_count');
                    break;
                case 'price_low':
                    Log::info("Sorting by price (low to high)");
                    $query->withAvg('services', 'price')->orderBy('services_avg_price');
                    break;
                case 'price_high':
                    Log::info("Sorting by price (high to low)");
                    $query->withAvg('services', 'price')->orderByDesc('services_avg_price');
                    break;
                default:
                    Log::info("Sorting by newest");
                    $query->orderByDesc('created_at');
                    break;
            }

            // Get total filtered count for metrics
            $totalFilteredArtisans = $query->count();
            Log::info("Total artisans after filtering: {$totalFilteredArtisans}");

            // Execute the query with pagination
            $artisans = $query->paginate(12);
            Log::info("Artisans fetched for display: " . count($artisans));

            // Log some sample data for debugging
            if ($artisans->count() > 0) {
                $sample = $artisans->take(2)->map(function($item) {
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
                'availability',
                'totalAllArtisans',
                'totalFilteredArtisans'
            ));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            session()->flash('error', 'An error occurred while loading artisans: ' . $e->getMessage());
            return view('client.find-artisans', [
                'artisans' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12, 1),
                'categories' => Category::orderBy('name')->get()
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
            $availability = $request->input('availability', 'all'); // Add availability parameter

            // Build query
            $query = ArtisanProfile::with(['user', 'category'])
                ->whereHas('user', function ($q) {
                    $q->where('status', 'active');
                })
                ->where('status', 'approved');

            // Apply search filter if provided
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('profession', 'like', "%{$search}%")
                      ->orWhere('about_me', 'like', "%{$search}%")
                      ->orWhereHas('user', function($uq) use ($search) {
                          $uq->where('firstname', 'like', "%{$search}%")
                             ->orWhere('lastname', 'like', "%{$search}%");
                      });
                });
            }

            // Apply category filter if provided
            if ($category) {
                $query->whereHas('category', function($q) use ($category) {
                    $q->where('categories.id', $category);
                });
            }

            // Apply location filter if provided
            if ($location) {
                $query->where(function($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                      ->orWhere('country', 'like', "%{$location}%");
                });
            }

            // Apply availability filter if provided and not 'all'
            if ($availability && $availability !== 'all') {
                $query->whereHas('availabilities', function($q) use ($availability) {
                    if ($availability === 'available') {
                        $q->where('status', 'available');
                    } elseif ($availability === 'today') {
                        $q->whereDate('date', now()->toDateString())
                          ->where('status', 'available');
                    } elseif ($availability === 'this_week') {
                        $q->whereBetween('date', [
                            now()->startOfWeek()->toDateString(),
                            now()->endOfWeek()->toDateString()
                        ])->where('status', 'available');
                    }
                });
            }

            // Apply sorting
            switch ($sortBy) {
                case 'rating':
                    $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                    break;
                case 'reviews':
                    $query->withCount('reviews')->orderByDesc('reviews_count');
                    break;
                case 'price_low':
                    $query->withAvg('services', 'price')->orderBy('services_avg_price');
                    break;
                case 'price_high':
                    $query->withAvg('services', 'price')->orderByDesc('services_avg_price');
                    break;
                default:
                    $query->orderByDesc('created_at');
                    break;
            }

            // Paginate the results
            $artisans = $query->paginate(12);

            // Return JSON response in the required format
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
            $artisan = ArtisanProfile::with(['user', 'services', 'reviews', 'availabilities', 'skills'])
                ->where('status', 'approved')
                ->findOrFail($id);

            return view('client.artisans.show', compact('artisan'));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::show: " . $e->getMessage());
            session()->flash('error', 'Artisan profile not found or not available.');
            return redirect()->route('client.find-artisans');
        }
    }
}