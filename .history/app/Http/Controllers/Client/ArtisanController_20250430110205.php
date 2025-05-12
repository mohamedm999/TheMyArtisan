<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    protected $artisanProfileRepository;

    public function __construct(ArtisanProfileRepositoryInterface $artisanProfileRepository)
    {
        $this->artisanProfileRepository = $artisanProfileRepository;
    }

    public function index(Request $request)
    {
        try {
            // Create filters array from request
            $filters = [
                'search' => $request->filled('search') ? $request->search : null,
                'category' => $request->filled('category') ? $request->category : null,
                'location' => $request->filled('city') ? $request->city : null,
                'country' => $request->filled('country') ? $request->country : null,
                'sort' => $request->filled('sort') ? $request->sort : 'newest',
                'per_page' => 12
            ];

            // Get all categories, countries and cities for the filter
            $categories = Category::where('is_active', true)->orderBy('name')->get();
            $countries = Country::where('is_active', true)->orderBy('name')->get();
            $cities = City::where('is_active', true)->orderBy('name')->get();

            // If repository method is failing, directly query artisans as a fallback
            try {
                // First attempt with repository
                $artisans = $this->artisanProfileRepository->getClientFilteredArtisans($filters);
            } catch (\Exception $e) {
                Log::error('Repository method failed: ' . $e->getMessage());

                // Fallback direct query if repository method fails
                $query = ArtisanProfile::with(['user', 'category', 'services', 'reviews'])
                    ->whereIn('status', ['approved', 'active']) // Include both approved and active artisans
                    ->whereHas('user', function ($q) {
                        $q->where('status', 'active');
                    });

                // Apply search if provided
                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->whereHas('user', function($uq) use ($search) {
                            $uq->where('firstname', 'like', "%{$search}%")
                               ->orWhere('lastname', 'like', "%{$search}%");
                        })
                        ->orWhere('profession', 'like', "%{$search}%")
                        ->orWhere('about_me', 'like', "%{$search}%");
                    });
                }

                // Apply category filter if provided
                if ($request->filled('category')) {
                    $query->whereHas('category', function ($q) use ($request) {
                        $q->where('category_id', $request->category);
                    });
                }

                // Apply city filter if provided
                if ($request->filled('city')) {
                    $query->where('city_id', $request->city);
                }

                // Apply country filter if provided
                if ($request->filled('country')) {
                    $query->where('country_id', $request->country);
                }

                // Apply sorting
                $sortBy = $request->sort ?? 'newest';
                switch ($sortBy) {
                    case 'rating':
                        // Sort by average rating
                        $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                        break;
                    case 'reviews':
                        // Sort by number of reviews
                        $query->withCount('reviews')->orderByDesc('reviews_count');
                        break;
                    default:
                        // Default to sorting by newest
                        $query->orderByDesc('created_at');
                        break;
                }

                $artisans = $query->paginate(12);
            }

            // Log how many artisans we found for debugging
            Log::info('Artisans fetched: ' . $artisans->count() . ' total: ' . $artisans->total());

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'));
        } catch (\Exception $e) {
            // Log any errors for debugging
            Log::error('Error in ArtisanController@index: ' . $e->getMessage());
            Log::error('Error stack trace: ' . $e->getTraceAsString());

            // Return an empty collection but still pass the categories, countries and cities
            $artisans = new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                12,
                1,
                ['path' => request()->url()]
            );
            $categories = Category::where('is_active', true)->orderBy('name')->get();
            $countries = Country::where('is_active', true)->orderBy('name')->get();
            $cities = City::where('is_active', true)->orderBy('name')->get();

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'))
                  ->with('error', 'An error occurred while retrieving the artisans. Please try again later.');
        }
    }

    public function show($id)
    {
        try {
            // Get artisan detail using repository
            $artisan = $this->artisanProfileRepository->getArtisanDetail($id);

            if (!$artisan) {
                return view('errors.custom', [
                    'message' => 'Artisan profile not found.',
                    'code' => 404
                ]);
            }

            // Only allow admins to view unapproved artisans
            $currentUser = Auth::user();
            $isAdmin = $currentUser && ($currentUser->role === 'admin' || ($currentUser->roles && $currentUser->roles->contains('name', 'admin')));

            if (!$isAdmin && !in_array($artisan->status, ['approved', 'active'])) {
                return view('errors.custom', [
                    'message' => 'This artisan is not yet approved. Please contact an administrator.',
                    'code' => 403
                ]);
            }

            // If viewing as admin, add a notification flag
            $viewingAsAdmin = $isAdmin && !in_array($artisan->status, ['approved', 'active']);

            return view('client.artisans.show', compact('artisan', 'viewingAsAdmin'));
        } catch (\Exception $e) {
            Log::error('Error in ArtisanController@show: ' . $e->getMessage());

            return view('errors.custom', [
                'message' => 'An error occurred while retrieving the artisan profile.',
                'code' => 500
            ]);
        }
    }
}
