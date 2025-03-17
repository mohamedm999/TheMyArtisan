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