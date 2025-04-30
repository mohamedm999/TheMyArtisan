<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = ArtisanProfile::with(['user', 'categories', 'reviews']);

            // Apply filters if provided
            if ($request->filled('category')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category);
                });
            }

            if ($request->filled('country')) {
                $query->where('country_id', $request->country);
            }

            if ($request->filled('city')) {
                $query->where('city_id', $request->city);
            }

            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('user', function ($q) use ($searchTerm) {
                        $q->where('firstname', 'like', "%{$searchTerm}%")
                            ->orWhere('lastname', 'like', "%{$searchTerm}%");
                    })
                        ->orWhere('profession', 'like', "%{$searchTerm}%")
                        ->orWhere('about_me', 'like', "%{$searchTerm}%");
                });
            }

            // Get all categories for the filter
            $categories = Category::where('is_active', true)->get();

            // Get countries and cities for the filters
            $countries = Country::where('is_active', true)->get();
            $cities = City::where('is_active', true)->get();

            // Get the artisans with pagination
            $artisans = $query->paginate(12);

            // Log how many artisans we found for debugging
            Log::info('Artisans fetched: ' . $artisans->count() . ' total: ' . $artisans->total());

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
        $artisan = ArtisanProfile::with([
            'user',
            'services.category',
            'reviews.user',
            'workExperiences',
            'certifications',
            'availabilities',
            'categories',
            'city',
            'country',
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        // Only allow admins to view unapproved artisans
        $currentUser = Auth::user();
        $isAdmin = $currentUser && ($currentUser->role === 'admin' || ($currentUser->roles && $currentUser->roles->contains('name', 'admin')));

        if (!$isAdmin && $artisan->status !== ArtisanProfile::STATUS_APPROVED) {
            abort(403, 'This artisan is not yet approved. Please contact an administrator.');
        }

        // If viewing as admin, add a notification flag
        $viewingAsAdmin = $isAdmin && $artisan->status !== ArtisanProfile::STATUS_APPROVED;

        return view('client.artisans.show', compact('artisan', 'viewingAsAdmin'));
    }
}
