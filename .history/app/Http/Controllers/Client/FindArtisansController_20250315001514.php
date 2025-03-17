<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ArtisanProfile;
use App\Models\ArtisanService;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindArtisansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:client');
    }

    /**
     * Display the search form
     */
    public function index()
    {
        // Get service categories for filter options
        $categories = ArtisanService::select('category')->distinct()->pluck('category');

        // Get all available artisans for initial display
        $artisans = User::whereHas('roles', function ($q) {
            $q->where('name', 'artisan');
        })
        ->whereHas('artisanProfile', function($q) {
            $q->where('is_verified', true);
        })
        ->with('artisanProfile', 'artisanProfile.services')
        ->paginate(10);

        return view('client.find-artisans.index', compact('categories', 'artisans'));
    }

    /**
     * Search for artisans based on criteria
     */
    public function search(Request $request)
    {
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'artisan');
        })
        ->whereHas('artisanProfile', function($q) {
            $q->where('is_verified', true);
        })
        ->with('artisanProfile', 'artisanProfile.services');

        // Apply filters if provided
        if ($request->filled('category')) {
            $query->whereHas('artisanProfile.services', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        if ($request->filled('location')) {
            $query->whereHas('artisanProfile', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('skill')) {
            $query->whereHas('artisanProfile.services', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->skill . '%')
                    ->orWhere('description', 'like', '%' . $request->skill . '%');
            });
        }

        // Save search history
        if ($request->filled('category') || $request->filled('location') || $request->filled('skill')) {
            SearchHistory::create([
                'user_id' => Auth::id(),
                'search_params' => json_encode($request->only(['category', 'location', 'skill'])),
            ]);
        }

        $artisans = $query->paginate(10);

        // Check if request is AJAX
        if ($request->ajax()) {
            $view = view('client.find-artisans.partials.artisans-list', compact('artisans'))->render();
            return response()->json([
                'html' => $view,
                'pagination' => $artisans->links()->toHtml(),
                'count' => $artisans->total()
            ]);
        }

        return view('client.find-artisans.results', compact('artisans'));
    }

    /**
     * View artisan details
     */
    public function viewArtisan($id)
    {
        $artisan = User::whereHas('roles', function ($q) {
            $q->where('name', 'artisan');
        })->with('artisanProfile', 'artisanProfile.services')->findOrFail($id);

        return view('client.find-artisans.view', compact('artisan'));
    }

    /**
     * Show recent searches
     */
    public function searchHistory()
    {
        $searches = SearchHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('client.find-artisans.history', compact('searches'));
    }
}
