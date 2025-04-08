<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtisanProfile::with(['user', 'categories'])
            ->whereHas('user', function ($q) {
                $q->whereHas('roles', function ($q) {
                    $q->where('name', 'artisan');
                });
            });

        // Apply status filter after the whereHas clauses
        $query->where('approval_status', 'approved'); // Changed from 'status' to 'approval_status'

        // Apply filters if provided
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('specialty', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('firstname', 'like', '%' . $searchTerm . '%')
                            ->orWhere('lastname', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Get all categories for the filter
        $categories = Category::where('is_active', true)->get();

        // Get the artisans
        $artisans = $query->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12)
            ->withQueryString();

        return view('client.artisans.index', compact('artisans', 'categories'));
    }

    public function show($id)
    {
        $artisan = ArtisanProfile::with([
            'user',
            'services.category',
            'reviews.user',
            'workExperiences',
            'certifications',
            'availabilities',
            'categories'
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        // Ensure the artisan is approved
        if ($artisan->approval_status !== 'approved') { // Changed from 'status' to 'approval_status'
            abort(403, 'This artisan is not yet approved.');
        }

        return view('client.artisans.show', compact('artisan'));
    }
}
