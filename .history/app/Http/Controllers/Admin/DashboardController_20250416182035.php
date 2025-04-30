<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        // Get counts for dashboard stats
        $totalUsers = User::count();
        $artisansCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->count();
        $clientsCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'client');
        })->count();

        $bookingsCount = Booking::count();

        // Additional counts for expanded dashboard - safely handle potential missing models
        $servicesCount = class_exists('App\Models\Service') ? Service::count() : 0;
        $categoriesCount = class_exists('App\Models\Category') ? Category::count() : 0;

        // Safely check for Review model
        $reviewsCount = 0;
        if (class_exists('App\Models\Review')) {
            try {
                $reviewsCount = \App\Models\Review::count();
            } catch (\Exception $e) {
                // Model exists but might have issues - leave count at 0
            }
        }

        // Safely check for Message model
        $messagesCount = 0;
        if (class_exists('App\Models\Message')) {
            try {
                $messagesCount = \App\Models\Message::count();
            } catch (\Exception $e) {
                // Model exists but might have issues - leave count at 0
            }
        }

        // Get recent activities (last 5)
        $recentActivities = $this->getRecentActivities();

        // Get latest registered users (last 5)
        $latestUsers = User::latest()->take(5)->get();
        // Add role information to each user
        $latestUsers->each(function ($user) {
            $user->role = $user->roles->first() ? $user->roles->first()->name : 'client';
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'artisansCount',
            'clientsCount',
            'bookingsCount',
            'servicesCount',
            'categoriesCount',
            'reviewsCount',
            'messagesCount',
            'recentActivities',
            'latestUsers'
        ));
    }

    /**
     * Get recent activities across the platform
     *
     * @return \Illuminate\Support\Collection
     */
    private function getRecentActivities()
    {


        // Otherwise, create a synthetic collection of activities
        $activities = collect();

        // Get recent user registrations
        $recentUsers = User::latest()->take(3)->get();
        foreach ($recentUsers as $user) {
            $role = $user->roles->first() ? $user->roles->first()->name : 'client';
            $activities->push((object)[
                'title' => 'New ' . ucfirst($role) . ' Registration',
                'description' => $user->first . ' joined the platform',
                'created_at' => $user->created_at,
                'icon' => $role === 'artisan' ? 'hammer' : 'user'
            ]);
        }

        // Get recent bookings
        try {
            $recentBookings = Booking::with(['client', 'service'])->latest()->take(3)->get();
            foreach ($recentBookings as $booking) {
                if (isset($booking->client) && isset($booking->service)) {
                    $activities->push((object)[
                        'title' => 'New Booking',
                        'description' => $booking->client->name . ' booked ' . $booking->service->name,
                        'created_at' => $booking->created_at,
                        'icon' => 'calendar-check'
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Skip bookings if there's an issue with relationships
        }

        // Get recent reviews if available
        if (class_exists('App\Models\Review')) {
            try {
                $recentReviews = \App\Models\Review::with(['user', 'artisan'])->latest()->take(2)->get();
                foreach ($recentReviews as $review) {
                    if (isset($review->user)) {
                        $activities->push((object)[
                            'title' => 'New Review',
                            'description' => $review->user->name . ' left a ' . $review->rating . '-star review',
                            'created_at' => $review->created_at,
                            'icon' => 'star'
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Skip reviews if there's an issue
            }
        }

        // Sort activities by created_at
        return $activities->sortByDesc('created_at')->take(5);
    }
}
