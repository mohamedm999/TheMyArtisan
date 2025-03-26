<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\SavedArtisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // Load all active countries and cities for the filter dropdown
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

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

        // Apply country filter if set
        if ($request->has('country') && !empty($request->country)) {
            $query->where('country_id', $request->country);
        }

        // Apply city filter if set
        if ($request->has('city') && !empty($request->city)) {
            $query->where('city_id', $request->city);
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

        return view('client.artisans.index', compact('artisans', 'categories', 'countries', 'cities'));
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

    /**
     * Save an artisan to the client's saved list
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveArtisan($id)
    {
        $artisan = ArtisanProfile::findOrFail($id);
        $client = Auth::user();

        // Check if already saved
        $existingSave = SavedArtisan::where('user_id', $client->id)
            ->where('artisan_profile_id', $artisan->id)
            ->first();

        if (!$existingSave) {
            SavedArtisan::create([
                'user_id' => $client->id,
                'artisan_profile_id' => $artisan->id
            ]);

            return redirect()->back()->with('success', 'Artisan saved to your list successfully!');
        }

        return redirect()->back()->with('info', 'This artisan is already in your saved list.');
    }

    /**
     * Remove an artisan from the client's saved list
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unsaveArtisan($id)
    {
        $artisan = ArtisanProfile::findOrFail($id);
        $client = Auth::user();

        SavedArtisan::where('user_id', $client->id)
            ->where('artisan_profile_id', $artisan->id)
            ->delete();

        return redirect()->back()->with('success', 'Artisan removed from your saved list.');
    }
}
