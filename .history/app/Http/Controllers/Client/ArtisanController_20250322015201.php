<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ArtisanController extends Controller
{
    /**
     * Display a listing of the artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Load all active categories for the filter dropdown
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $query = ArtisanProfile::with([
            'user',
            'services',
            'certifications',
            'workExperiences',
            'reviews',
            'categories'
        ]);

        // Apply category filter if set
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Apply search filter if set
        if ($request->has('search') && !empty($request->search)) {
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

        // Apply location filter if set
        if ($request->has('location') && !empty($request->location)) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                    ->orWhere('country', 'like', "%{$location}%");
            });
        }

        // Apply sorting
        $sortOption = $request->get('sort', 'newest');
        switch ($sortOption) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating_high':
                $query->withCount(['reviews as average_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }])->orderBy('average_rating', 'desc');
                break;
            case 'rating_low':
                $query->withCount(['reviews as average_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }])->orderBy('average_rating', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $artisans = $query->paginate(12)->withQueryString();

        // Calculate rating for each artisan
        foreach ($artisans as $artisan) {
            $artisan->rating = $artisan->getAverageRatingAttribute();
            $artisan->reviews_count = $artisan->getTotalReviewsAttribute();
        }

        // The view name can be either find-artisans or artisans.index
        return view('client.find-artisans', compact('artisans', 'categories'));
    }

    /**
     * Display the specified artisan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = ArtisanProfile::with([
            'user',
            'services.category',
            'certifications',
            'workExperiences',
            'availabilities',
            'reviews.user'
        ])->findOrFail($id);

        // Calculate the average rating and review count
        $artisan->average_rating = $artisan->getAverageRatingAttribute();
        $artisan->reviews_count = $artisan->getTotalReviewsAttribute();

        return view('client.artisans.show', compact('artisan'));
    }
}
