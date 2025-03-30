<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Category;
use App\Models\Review;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get counts for dashboard statistics
        $totalUsers = User::count();
        $artisansCount = User::where('role', 'artisan')->count();
        $clientsCount = User::where('role', 'client')->count();
        $bookingsCount = Booking::count();
        $servicesCount = Service::count() ?? 0;
        $categoriesCount = Category::count() ?? 0;
        $reviewsCount = Review::count() ?? 0;
        $messagesCount = 0; // You'll need to create a Message model or adjust this

        // Get latest users for the dashboard
        $latestUsers = User::latest()->take(5)->get();

        // Get recent activities (replace with your actual activity model)
        $recentActivities = collect(); // Empty collection for now

        return view('admin.dashboard', compact(
            'totalUsers',
            'artisansCount',
            'clientsCount',
            'bookingsCount',
            'servicesCount',
            'categoriesCount',
            'reviewsCount',
            'messagesCount',
            'latestUsers',
            'recentActivities'
        ));
    }
}
