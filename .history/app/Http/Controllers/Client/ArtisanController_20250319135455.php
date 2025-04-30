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
use Illuminate\Support\Facades\Log;

class ArtisanController extends Controller
{
    /**
     * Display a listing of available artisans.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Get all categories for the filter
            $categories = Category::orderBy('name')->get();

            // Get the artisan role
            $artisanRole = Role::where('name', 'artisan')
                ->orWhere('name', 'Artisan')
                ->first();

            // Query builder for artisans using Eloquent relationships
            $query = User::whereHas('roles', function ($q) use ($artisanRole) {
                $q->where('roles.id', $artisanRole->id);
            })
                ->whereHas('artisanProfile', function ($q) {
                    // You can add conditions here if needed, like active status
                })
                ->with(['artisanProfile' => function ($q) {
                    $q->with(['services', 'reviews', 'certifications', 'workExperiences']);
                }]);

            // Apply search filters
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%")
                        ->orWhereHas('artisanProfile', function ($subQ) use ($search) {
                            $subQ->where('business_name', 'like', "%{$search}%")
                                ->orWhere('profession', 'like', "%{$search}%")
                                ->orWhere('city', 'like', "%{$search}%");
                        });
                });
            }

            // Apply category filter
            if ($request->filled('category')) {
                $categoryId = $request->category;
                $query->whereHas('artisanProfile.services', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            }

            // Get paginated results
            $artisans = $query->paginate(12);

            // Calculate ratings for each artisan
            foreach ($artisans as $artisan) {
                $reviews = Review::where('artisan_id', $artisan->id)->get();
                $artisan->rating = $reviews->avg('rating') ?? 0;
                $artisan->reviews_count = $reviews->count();

                // Add computed full address to artisan profile
                if ($artisan->artisanProfile) {
                    $artisan->artisanProfile->fullAddress = $this->getFullAddress($artisan->artisanProfile);
                }
            }

            return view('client.artisans.index', compact('artisans', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error fetching artisans: ' . $e->getMessage());
            return view('client.artisans.index', [
                'error' => 'An error occurred while fetching artisans. Please try again later.',
                'categories' => Category::orderBy('name')->get(),
                'artisans' => collect(),
            ]);
        }
    }

    /**
     * Display the specified artisan's profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            // Get user with eager loaded artisan profile and related data
            $user = User::with([
                'artisanProfile',
                'artisanProfile.services' => function ($query) {
                    $query->where('is_active', true);
                },
                'artisanProfile.certifications',
                'artisanProfile.workExperiences' => function ($query) {
                    $query->orderBy('start_date', 'desc');
                }
            ])->findOrFail($id);

            // Validate that this user is an artisan
            $artisanRole = Role::where('name', 'artisan')
                ->orWhere('name', 'Artisan')
                ->first();

            if (!$user->roles->contains($artisanRole->id)) {
                return redirect()->route('client.artisans.index')
                    ->with('error', 'The requested profile is not an artisan.');
            }

            if (!$user->artisanProfile) {
                return redirect()->route('client.artisans.index')
                    ->with('error', 'This artisan does not have a complete profile yet.');
            }

            // Get reviews with pagination
            $reviews = Review::where('artisan_id', $id)
                ->with('customer')
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            // Calculate average rating
            $averageRating = Review::where('artisan_id', $id)->avg('rating') ?? 0;
            $reviewsCount = Review::where('artisan_id', $id)->count();

            // Add computed full address
            $user->artisanProfile->fullAddress = $this->getFullAddress($user->artisanProfile);

            // Prepare artisan object for view
            $artisan = (object)[
                'id' => $user->id,
                'name' => $user->firstname . ' ' . $user->lastname,
                'email' => $user->email,
                'artisanProfile' => $user->artisanProfile
            ];

            // Pass all data to the view
            return view('client.artisans.show', compact(
                'artisan',
                'reviews',
                'averageRating',
                'reviewsCount'
            ));
        } catch (\Exception $e) {
            Log::error('Error showing artisan profile: ' . $e->getMessage());
            return redirect()->route('client.artisans.index')
                ->with('error', 'An error occurred while loading the artisan profile.');
        }
    }

    /**
     * Generate full address from artisan profile components
     *
     * @param ArtisanProfile $profile
     * @return string
     */
    private function getFullAddress($profile)
    {
        $addressParts = [];

        if (!empty($profile->address)) {
            $addressParts[] = $profile->address;
        }
        if (!empty($profile->city)) {
            $addressParts[] = $profile->city;
        }
        if (!empty($profile->postal_code)) {
            $addressParts[] = $profile->postal_code;
        }
        if (!empty($profile->country)) {
            $addressParts[] = $profile->country;
        }

        return !empty($addressParts) ? implode(', ', $addressParts) : 'Location not specified';
    }
}
