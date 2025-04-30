<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ArtisanProfile;
use App\Models\Service;
use App\Models\Category;
use App\Models\Review;

class ArtisanController extends Controller
{
    /**
     * Display a listing of artisans.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $category_id = $request->input('category');
        $craft_type = $request->input('craft_type');
        $rating = $request->input('rating');
        $location = $request->input('location');
        $search = $request->input('search');

        // Start with all artisans who are active
        $artisansQuery = User::role('artisan')
            ->whereHas('artisanProfile', function ($query) {
                $query->where('status', 'active');
            })
            ->with(['artisanProfile', 'artisanProfile.categories']);

        // Apply filters
        if ($category_id) {
            $artisansQuery->whereHas('artisanProfile.categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            });
        }

        if ($craft_type) {
            $artisansQuery->whereHas('artisanProfile', function ($query) use ($craft_type) {
                $query->where('craft_type', 'like', "%{$craft_type}%");
            });
        }

        if ($rating) {
            $artisansQuery->whereHas('artisanProfile', function ($query) use ($rating) {
                $query->where('avg_rating', '>=', $rating);
            });
        }

        if ($location) {
            $artisansQuery->whereHas('artisanProfile', function ($query) use ($location) {
                $query->where('city', 'like', "%{$location}%")
                      ->orWhere('region', 'like', "%{$location}%");
            });
        }

        if ($search) {
            $artisansQuery->where(function ($query) use ($search) {
                $query->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%")
                      ->orWhereHas('artisanProfile', function ($subquery) use ($search) {
                          $subquery->where('bio', 'like', "%{$search}%")
                                  ->orWhere('business_name', 'like', "%{$search}%");
                      });
            });
        }

        // Get artisans with pagination
        $artisans = $artisansQuery->paginate(12);

        // Get all categories for the filter sidebar
        $categories = Category::all();

        // Get popular locations for filter
        $locations = ArtisanProfile::select('city')
                        ->where('city', '!=', '')
                        ->groupBy('city')
                        ->orderByRaw('COUNT(*) DESC')
                        ->limit(10)
                        ->get();

        return view('client.artisans.index', compact('artisans', 'categories', 'locations'));
    }

    /**
     * Display the specified artisan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the artisan with related data
        $artisan = User::role('artisan')
            ->with([
                'artisanProfile',
                'artisanProfile.categories',
                'artisanProfile.certifications',
                'artisanProfile.workExperiences',
                'services' => function($query) {
                    $query->where('status', 'active');
                },
                'reviews' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'reviews.user',
                'portfolio' => function($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->findOrFail($id);

        // Get related artisans in the same categories
        $relatedArtisans = collect();
        if ($artisan->artisanProfile) {
            $categoryIds = $artisan->artisanProfile->categories->pluck('id');

            if ($categoryIds->count() > 0) {
                $relatedArtisans = User::role('artisan')
                    ->where('id', '!=', $id)
                    ->whereHas('artisanProfile.categories', function($query) use ($categoryIds) {
                        $query->whereIn('categories.id', $categoryIds);
                    })
                    ->with('artisanProfile')
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();
            }
        }

        return view('client.artisans.show', compact('artisan', 'relatedArtisans'));
    }
}
