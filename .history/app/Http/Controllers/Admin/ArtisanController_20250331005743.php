<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Country;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ArtisanStatusUpdated;

class ArtisanController extends Controller
{
    public function index(Request $request)
    {
        // First, get all users with the artisan role
        $artisanUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->get();

        // Create artisan profiles for users who don't have them
        foreach ($artisanUsers as $user) {
            if (!$user->artisanProfile) {
                // Create a default artisan profile for this user with only fillable fields
                ArtisanProfile::create([
                    'user_id' => $user->id,
                ]);
            }
        }

        // Now proceed with the regular query with eager loading
        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with([
            'artisanProfile',
            'artisanProfile.categories',
            'artisanProfile.services',
            'artisanProfile.reviews',
            'artisanProfile.city',
            'artisanProfile.country',
        ]);

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('artisanProfile', function ($q) use ($search) {
                        $q->where('specialty', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->whereHas('artisanProfile', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Apply country filter
        if ($request->has('country') && !empty($request->country)) {
            $query->whereHas('artisanProfile', function ($q) use ($request) {
                $q->where('country_id', $request->country);
            });
        }

        // Apply category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('artisanProfile.categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $artisans = $query->paginate(10);

        // Get statistics for dashboard
        $stats = [
            'total' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->count(),
            'pending' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'pending');
            })->count(),
            'approved' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'approved');
            })->count(),
            'rejected' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'rejected');
            })->count(),
        ];

        // Get filter options
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.artisans.index', compact('artisans', 'stats', 'countries', 'categories'));
    }

    public function show($id)
    {
        $artisan = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with([
            'artisanProfile',
            'artisanProfile.categories',
            'artisanProfile.services',
            'artisanProfile.reviews',
            'artisanProfile.bookings',
            'artisanProfile.city',
            'artisanProfile.country',
            'artisanProfile.workExperiences',
            'artisanProfile.certifications',
        ])->findOrFail($id);

        return view('admin.artisans.show', compact('artisan'));
    }

    /**
     * Approve an artisan profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->artisanProfile;

        if (!$profile) {
            return back()->with('error', 'This artisan does not have a profile.');
        }

        $profile->status = ArtisanProfile::STATUS_APPROVED;
        $profile->save();

        // Optional: Send notification to the artisan
        try {
            $user->notify(new ArtisanStatusUpdated('approved'));
        } catch (\Exception $e) {
            // Log the error but continue
        }

        return back()->with('success', 'Artisan has been approved successfully.');
    }

    /**
     * Reject an artisan profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->artisanProfile;

        if (!$profile) {
            return back()->with('error', 'This artisan does not have a profile.');
        }

        $profile->status = ArtisanProfile::STATUS_REJECTED;
        $profile->save();

        // Optional: Send notification to the artisan
        try {
            $user->notify(new ArtisanStatusUpdated('rejected'));
        } catch (\Exception $e) {
            // Log the error but continue
        }

        return back()->with('success', 'Artisan has been rejected.');
    }

    public function export()
    {
        // Logic to export artisans to CSV/Excel
        return redirect()->route('admin.artisans.index')
            ->with('success', 'Artisans exported successfully.');
    }

    public function services($id)
    {
        $artisan = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with(['artisanProfile.services'])->findOrFail($id);

        return view('admin.artisans.services', compact('artisan'));
    }
}
