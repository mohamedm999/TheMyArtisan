<?php

namespace App\Http\Controllers\Client;


class FindArtisansController extends Controller
{
    /**
     * Display a listing of the artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $artisans = Artisan::where('status', 'active')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('client.artisans.index', compact('artisans'));
    }

    /**
     * Search for artisans based on filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Artisan::where('status', 'active');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }

        if ($request->has('skill')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->skill.'%');
            });
        }

        $artisans = $query->orderBy('rating', 'desc')
                         ->paginate(12);

        return view('client.artisans.search', compact('artisans'));
    }

    /**
     * Display the specified artisan profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = Artisan::findOrFail($id);
        return view('client.artisans.show', compact('artisan'));
    }
}
