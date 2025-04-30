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
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArtisanController extends Controller
{
    /**
     * Display a listing of available artisans.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get column information for debugging
        $userColumns = Schema::getColumnListing('users');
        $artisanProfilesColumns = Schema::getColumnListing('artisan_profiles');

        // Debug information
        $debugInfo = [
            'artisan_role' => Role::where('name', 'artisan')->orWhere('name', 'Artisan')->first(),
            'artisan_profiles_count' => ArtisanProfile::count(),
            'users_count' => User::count(),
            'role_users' => DB::table('role_user')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('roles.name', 'artisan')
                ->orWhere('roles.name', 'Artisan')
                ->count(),
            'user_columns' => $userColumns,
            'artisan_profiles_columns' => $artisanProfilesColumns
        ];

        // Build the SELECT clause dynamically based on available columns
        $selectArray = [
            'users.id as user_id',
            DB::raw("CONCAT(IFNULL(users.firstname, ''), ' ', IFNULL(users.lastname, '')) as name"),
            'users.email'
        ];

        // Check for specific columns in artisan_profiles and add them if they exist
        $columnsToCheck = [
            'business_name',
            'profession',
            'city',
            'profile_photo'
        ];

        foreach ($columnsToCheck as $column) {
            if (in_array($column, $artisanProfilesColumns)) {
                $selectArray[] = "artisan_profiles.$column";
            }
        }

        // Try a more lenient query to find any artisans
        $query = DB::table('users')
            ->join('artisan_profiles', 'users.id', '=', 'artisan_profiles.user_id')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where(function ($q) {
                $q->where('roles.name', 'artisan')
                    ->orWhere('roles.name', 'Artisan');
            })
            ->select($selectArray);

        // Apply filters
        if ($request->filled('category')) {
            // Check if category_id exists, otherwise try looking for category-related columns
            if (in_array('category_id', $artisanProfilesColumns)) {
                $query->where('artisan_profiles.category_id', $request->category);
            } else {
                // Try with profession or other potential category indicators
                // This is a fallback if there's no direct category relationship
                if (in_array('profession', $artisanProfilesColumns)) {
                    // This is just a basic fallback - you may need a more sophisticated approach
                    $category = Category::find($request->category);
                    if ($category) {
                        $query->where('artisan_profiles.profession', 'like', "%{$category->name}%");
                    }
                }
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $artisanProfilesColumns) {
                $q->where(DB::raw("CONCAT(users.firstname, ' ', users.lastname)"), 'like', "%{$search}%");

                // Only add these conditions if the columns exist
                if (in_array('business_name', $artisanProfilesColumns)) {
                    $q->orWhere('artisan_profiles.business_name', 'like', "%{$search}%");
                }
                if (in_array('profession', $artisanProfilesColumns)) {
                    $q->orWhere('artisan_profiles.profession', 'like', "%{$search}%");
                }
                if (in_array('city', $artisanProfilesColumns)) {
                    $q->orWhere('artisan_profiles.city', 'like', "%{$search}%");
                }
            });
        }

        // Get the SQL query for debugging
        $sqlQuery = $query->toSql();
        $bindings = $query->getBindings();

        $artisans = $query->paginate(12);

        // Additional debugging to see exactly what fields we have
        if ($artisans->count() > 0) {
            $debugInfo['sample_artisan_fields'] = get_object_vars($artisans->first());
        }

        $categories = Category::orderBy('name')->get();

        // Get average ratings
        foreach ($artisans as $artisan) {
            $artisan->rating = Review::where('artisan_id', $artisan->user_id)->avg('rating') ?? 0;
            $artisan->reviews_count = Review::where('artisan_id', $artisan->user_id)->count();
        }

        return view('client.artisans.index', compact('artisans', 'categories', 'debugInfo', 'sqlQuery', 'bindings'));
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
