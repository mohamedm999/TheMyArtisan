<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FindArtisansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:client');
    }

    /**
     * Display the find artisans page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.find-artisans');
    }

    /**
     * Search for artisans based on criteria
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // This will be implemented to search artisans based on:
        // - Search term (name, description)
        // - Category
        // - Location
        // - Rating

        // For now, just return to the find-artisans view
        return view('client.find-artisans');
    }
}
