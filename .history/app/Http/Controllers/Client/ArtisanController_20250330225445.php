<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtisanProfile::with(['user', 'categories'])
            ->whereHas('user', function ($q) {
                $q->whereHas('roles', function ($q) {
                    $q->where('name', 'artisan');
                });
            });

        // Remove the direct status filter since the column name is uncertain
        // We'll filter the collection after retrieving it

        // Apply filters if provided
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('specialty', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('firstname', 'like', '%' . $searchTerm . '%')
                            ->orWhere('lastname', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Get all categories for the filter
        $categories = Category::where('is_active', true)->get();
        
        // Get countries and cities for the filters
        $countries = Country::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        // Get the artisans
        $artisans = $query->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get(); // Get all matching artisans

        // Filter the collection to only show approved artisans
        $artisans = $artisans->filter(function ($artisan) {
            return $artisan->status === 'approved';
        });

        // Convert back to paginator
        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $pagedData = $artisans->forPage($currentPage, $perPage);
        $artisans = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $artisans->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'));
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
            'cities',
            'countries',
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        // Ensure the artisan is approved
        if ($artisan->user->status !== 'approved') {
            abort(403, 'This artisan is not yet approved.');
        }

        return view('client.artisans.show', compact('artisan'));
    }
}
