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
        // Modified query to avoid using role() method
        // Instead, we'll join with a role-related table or use a role field directly
        $query = DB::table('users')
            ->join('artisan_profiles', 'users.id', '=', 'artisan_profiles.user_id')
            // Assuming you have a 'role' column in the users table or a role-related table
            // Adjust this part according to your database structure
            ->where('users.role', 'artisan')  // Change this if your role system is different
            ->select('users.*', 'artisan_profiles.*', 'users.id as user_id');

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
        // Get artisan without using role()
        $artisan = User::where('id', $id)
            ->where('role', 'artisan')  // Change this if your role system is different
            ->with(['artisanProfile'])
            ->firstOrFail();

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
