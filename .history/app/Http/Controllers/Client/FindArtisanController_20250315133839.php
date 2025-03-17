<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class FindArtisanController extends Controller
{
    /**
     * Constructor to apply middleware if needed
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display the find artisans page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.find-artisans');
    }

    /**
     * Display an individual artisan's profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $artisan = User::whereHas('roles', function($query) {
            $query->where('name', 'artisan');
        })->findOrFail($id);

        return view('client.artisan-profile', compact('artisan'));
    }

    /**
     * Save an artisan to the client's favorites.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveArtisan($id, Request $request)
    {
        $artisan = User::whereHas('roles', function($query) {
            $query->where('name', 'artisan');
        })->findOrFail($id);

        // Add to favorites (requires favorites relationship to be set up)
        auth()->user()->favorites()->firstOrCreate([
            'artisan_id' => $artisan->id
        ]);

        return back()->with('success', 'Artisan added to favorites!');
    }
}
