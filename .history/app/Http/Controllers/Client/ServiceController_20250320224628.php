<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::with([
            'artisanProfile',
            'artisanProfile.user',
            'category',
            'reviews'
        ])->findOrFail($id);

        return view('client.services.show', compact('service'));
    }
}
