<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class FindArtisansController extends Controller
{
    /**
     * Display a listing of the artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $artisans = ArtisanProfile::where('status', 'active')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('client.artisans.index', compact('artisans', 'categories'));
    }

    /**
     * Search for artisans based on filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'category' => 'nullable|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'skill' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        $query = ArtisanProfile::where('status', 'active');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where(function(Builder $q) use ($request) {
                $q->where('location', 'like', '%'.$request->location.'%')
                  ->orWhere('city', 'like', '%'.$request->location.'%')
                  ->orWhere('state', 'like', '%'.$request->location.'%');
            });
        }

        if ($request->filled('skill')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->skill.'%');
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        $artisans = $query->orderBy('rating', 'desc')
                         ->paginate(12)
                         ->appends($request->except('page'));

        $categories = Category::all();

        return view('client.artisans.search', compact('artisans', 'categories'));
    }

    /**
     * Display the specified artisan profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = ArtisanProfile::with(['skills', 'reviews', 'portfolio'])
                                 ->findOrFail($id);
        return view('client.artisans.show', compact('artisan'));
    }
}
