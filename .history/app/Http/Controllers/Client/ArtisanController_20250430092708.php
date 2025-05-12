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

            // Get artisans using repository
            $artisans = $this->artisanProfileRepository->getClientFilteredArtisans($filters);

            // Log how many artisans we found for debugging
            Log::info('Artisans fetched: ' . $artisans->count() . ' total: ' . $artisans->total());

            // Get all categories for the filter
            $categories = Category::where('is_active', true)->get();

            // Get countries and cities for the filters
            $countries = Country::where('is_active', true)->get();
            $cities = City::where('is_active', true)->get();

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'));
        } catch (\Exception $e) {
            // Log any errors for debugging
            Log::error('Error in ArtisanController@index: ' . $e->getMessage());

            // Return an empty collection but still pass the categories, countries and cities
            $artisans = new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                12,
                1,
                ['path' => request()->url()]
            );
            $categories = Category::where('is_active', true)->get();
            $countries = Country::where('is_active', true)->get();
            $cities = City::where('is_active', true)->get();

            return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'));
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

            if (!$isAdmin && $artisan->status !== ArtisanProfile::STATUS_APPROVED) {
                return view('errors.custom', [
                    'message' => 'This artisan is not yet approved. Please contact an administrator.',
                    'code' => 403
                ]);
            }

            // If viewing as admin, add a notification flag
            $viewingAsAdmin = $isAdmin && $artisan->status !== ArtisanProfile::STATUS_APPROVED;

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
