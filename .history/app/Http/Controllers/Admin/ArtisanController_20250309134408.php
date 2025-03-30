<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function index()
    {
        $artisans = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with('profile')->paginate(10);

        return view('admin.artisans.index', compact('artisans'));
    }

    public function show($id)
    {
        $artisan = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with(['profile', 'services', 'bookings'])->findOrFail($id);

        return view('admin.artisans.show', compact('artisan'));
    }

    public function approve($id)
    {
        $artisan = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->findOrFail($id);

        $artisan->profile->update(['status' => 'approved']);

        return redirect()->route('admin.artisans.index')
            ->with('success', 'Artisan approved successfully.');
    }

    public function reject($id)
    {
        $artisan = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->findOrFail($id);

        $artisan->profile->update(['status' => 'rejected']);

        return redirect()->route('admin.artisans.index')
            ->with('success', 'Artisan rejected successfully.');
    }
}
