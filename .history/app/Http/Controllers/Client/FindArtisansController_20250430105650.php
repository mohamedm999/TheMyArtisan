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
            'location' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'sort' => 'nullable|in:rating,price_low,price_high,newest',
        ]);
        
        $query = ArtisanProfile::where('status', 'active');
        
        // Apply category filter
        if ($request->has('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
        
        // Apply location filter
        if ($request->has('location') && !empty($request->location)) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'like', '%'.$request->location.'%')
                  ->orWhere('address', 'like', '%'.$request->location.'%');
            });
        }
        
        // Apply rating filter
        if ($request->has('rating')) {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->selectRaw('AVG(rating) as avg_rating')
                  ->having('avg_rating', '>=', $request->rating);
            });
        }
        
        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->withCount(['reviews as average_rating' => function($query) {
                        $query->select(DB::raw('coalesce(avg(rating), 0)'));
                    }])->orderByDesc('average_rating');
                    break;
                case 'price_low':
                    $query->withAvg('services', 'price')->orderBy('services_avg_price');
                    break;
                case 'price_high':
                    $query->withAvg('services', 'price')->orderByDesc('services_avg_price');
                    break;
                case 'newest':
                    $query->orderByDesc('created_at');
                    break;
                default:
                    $query->orderByDesc('created_at');
            }
        } else {
            $query->orderByDesc('created_at');
        }
        
        $artisans = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        
        return view('client.artisans.index', compact('artisans', 'categories'));
    }
    
    /**
     * Display the specified artisan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = ArtisanProfile::with(['user', 'services', 'reviews', 'workExperiences', 'certifications'])
                    ->findOrFail($id);
        
        // Get average rating
        $averageRating = $artisan->reviews()->avg('rating') ?? 0;
        
        return view('client.artisans.show', compact('artisan', 'averageRating'));
    }
}