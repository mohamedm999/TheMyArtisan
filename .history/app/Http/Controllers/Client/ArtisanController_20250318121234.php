<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Service;
use App\Models\Review;
use App\Models\Certification;
use App\Models\WorkExperience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtisanController extends Controller
{
    /**
     * Display a listing of available artisans.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Modified query to work with your database structure
        // Now we just query users who have an artisan profile
        // Instead of filtering by role directly
        $query 

        // Apply filters
        if ($request->has('category')) {
            $query->where('artisan_profiles.category_id', $request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('artisan_profiles.business_name', 'like', "%{$search}%")
                    ->orWhere('artisan_profiles.profession', 'like', "%{$search}%")
                    ->orWhere('artisan_profiles.city', 'like', "%{$search}%");
            });
        }

        $artisans = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        // Get average ratings
        foreach ($artisans as $artisan) {
            $artisan->rating = Review::where('artisan_id', $artisan->user_id)->avg('rating') ?? 0;
            $artisan->reviews_count = Review::where('artisan_id', $artisan->user_id)->count();
        }

        return view('client.artisans.index', compact('artisans', 'categories'));
    }

    /**
     * Display the specified artisan's profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Get artisan by checking if they have an artisan profile
        $user = User::findOrFail($id);

        // Validate that this user is an artisan by checking for a profile
        $artisanProfile = ArtisanProfile::where('user_id', $id)->firstOrFail();

        // Now we know the user is an artisan with a profile
        $artisan = $user;
        $artisan->artisanProfile = $artisanProfile;

        // Get artisan's services
        $services = Service::where('user_id', $id)->where('is_active', true)->get();

        // Get artisan's reviews
        $reviews = Review::where('artisan_id', $id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $averageRating = Review::where('artisan_id', $id)->avg('rating') ?? 0;
        $reviewsCount = Review::where('artisan_id', $id)->count();

        // Get artisan's certifications
        $certifications = Certification::where('artisan_profile_id', $artisan->artisanProfile->id)->get();

        // Get artisan's work experiences
        $workExperiences = WorkExperience::where('artisan_profile_id', $artisan->artisanProfile->id)
            ->orderBy('end_date', 'desc')
            ->get();

        return view('client.artisans.show', compact(
            'artisan',
            'services',
            'reviews',
            'averageRating',
            'reviewsCount',
            'certifications',
            'workExperiences'
        ));
    }
}
