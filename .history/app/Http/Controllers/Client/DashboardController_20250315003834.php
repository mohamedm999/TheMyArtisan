<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:client');
    }

    public function index()
    {
        return view('client.dashboard');
    }

    public function profile()
    {
        // Redirect to the dedicated profile controller
        return app(ClientProfileController::class)->index();
    }

    public function findArtisans()
    {
        $categories = DB::table('categories')->get();
        $locations = User::where('role', 'artisan')
                         ->distinct()
                         ->pluck('city')
                         ->filter()
                         ->values();
                         
        return view('client.find-artisans', compact('categories', 'locations'));
    }
    
    /**
     * Search for artisans using AJAX
     */
    public function searchArtisans(Request $request)
    {
        $query = User::where('role', 'artisan')
                     ->where('is_approved', true);
                     
        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('category')) {
            $categoryId = $request->input('category');
            $query->whereHas('services', function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
        
        if ($request->filled('location')) {
            $query->where('city', $request->input('location'));
        }
        
        if ($request->filled('rating')) {
            $minRating = $request->input('rating');
            $query->whereHas('reviews', function($q) use ($minRating) {
                $q->select(DB::raw('AVG(rating) as average_rating'))
                  ->having('average_rating', '>=', $minRating);
            });
        }
        
        $artisans = $query->with(['services' => function($query) {
            $query->with('category');
        }, 'reviews'])->paginate(6);
        
        if ($request->ajax()) {
            return response()->json([
                'artisans' => $artisans,
                'pagination' => (string) $artisans->links('pagination::simple-bootstrap-4')
            ]);
        }
        
        return response()->json(['error' => 'Request is not ajax'], 400);
    }
    
    /**
     * Get services for an artisan
     */
    public function getArtisanServices($artisanId)
    {
        $services = Service::where('user_id', $artisanId)
                          ->with('category')
                          ->get();
                          
        return response()->json($services);
    }
    
    /**
     * Get service details
     */
    public function getServiceDetails($serviceId)
    {
        $service = Service::with(['user', 'category'])
                         ->findOrFail($serviceId);
                         
        return response()->json($service);
    }

    public function bookings()
    {
        return view('client.bookings');
    }

    public function savedArtisans()
    {
        return view('client.saved-artisans');
    }