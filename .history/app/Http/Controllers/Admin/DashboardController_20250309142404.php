<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.dashboard', compact(
            'totalUsers',
            'artisansCount',
            'clientsCount',
            'bookingsCount'
        ));
    }
}
