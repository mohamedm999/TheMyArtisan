<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Service;
use App\Models\Review;
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
            // Get categories for the filter dropdown
            $categories = Category::orderBy('name')->get();

            // Find artisans with a more reliable query
            $artisanRole = Role::where('name', 'artisan')
                ->orWhere('name', 'Artisan')
                ->first();

            if (!$artisanRole) {
                Log::error('Artisan role not found in database');
                throw new \Exception('Unable to find artisan role');
            }

            // Start with a simple query to get artisan users
            $artisanUsers = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->where('role_user.role_id', $artisanRole->id)
                ->select('users.id as user_id', 'users.firstname', 'users.lastname', 'users.email')
                ->get();

            Log::info('Retrieved artisan users', ['count' => $artisanUsers->count()]);

            // Get artisan profiles separately
            $artisanIds = $artisanUsers->pluck('user_id')->toArray();
            $profiles = ArtisanProfile::whereIn('user_id', $artisanIds)->get()->keyBy('user_id');

            // Load ratings
            $ratings = [];
            foreach ($artisanIds as $id) {
                $reviews = Review::where('artisan_id', $id)->get();
                $ratings[$id] = [
                    'average' => $reviews->avg('rating') ?? 0,
                    'count' => $reviews->count()
                ];
            }

            // Build artisan objects for the view
            $artisans = collect();
            foreach ($artisanUsers as $user) {
                $profile = $profiles->get($user->user_id);
                if (!$profile) {
                    // Skip users without profiles
                    continue;
                }

                // Apply search filter if provided
                if ($request->filled('search')) {
                    $search = strtolower($request->search);
                    $fullname = strtolower($user->firstname . ' ' . $user->lastname);
                    $businessName = $profile->business_name ? strtolower($profile->business_name) : '';
                    $profession = $profile->profession ? strtolower($profile->profession) : '';
                    $city = $profile->city ? strtolower($profile->city) : '';

                    // Skip if no match
                    if (
                        !str_contains($fullname, $search) &&
                        !str_contains($businessName, $search) &&
                        !str_contains($profession, $search) &&
                        !str_contains($city, $search)
                    ) {
                        continue;
                    }
                }

                // Apply category filter if provided
                if ($request->filled('category')) {
                    $categoryId = $request->category;
                    $hasService = Service::where('artisan_profile_id', $profile->id)
                        ->where('category_id', $categoryId)
                        ->exists();

                    // Skip if no matching service
                    if (!$hasService) {
                        continue;
                    }
                }

                // Create artisan object with needed properties
                $artisan = (object)[
                    'id' => $user->user_id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'rating' => $ratings[$user->user_id]['average'],
                    'reviews_count' => $ratings[$user->user_id]['count'],
                    'artisanProfile' => $profile,
                ];

                $artisans->push($artisan);
            }

            // Paginate the collection
            $page = $request->input('page', 1);
            $perPage = 12;
            $offset = ($page - 1) * $perPage;
            $items = $artisans->slice($offset, $perPage);
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $artisans->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            Log::info('Returning artisans list', [
                'count' => $paginator->count(),
                'total' => $paginator->total()
            ]);

            return view('client.artisans.index', compact('paginator', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in ArtisanController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return view with error message
            return view('client.artisans.index', [
                'error' => 'An error occurred while fetching artisans. Please try again later.',
                'categories' => Category::orderBy('name')->get(),
                'artisans' => collect()
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
