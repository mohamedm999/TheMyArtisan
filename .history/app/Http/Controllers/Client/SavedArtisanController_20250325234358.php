<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedArtisanController extends Controller
{
    /**
     * Display a listing of the saved artisans.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get all favorite artisans with their related data
        $savedArtisans = $user->favoriteArtisans()
            ->with(['artisanProfile', 'reviews'])
            ->paginate(12);

        return view('client.saved-artisans', compact('savedArtisans'));
    }

    /**
     * Remove an artisan from saved artisans.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $deleted = $user->favorites()->where('artisan_id', $id)->delete();

        if ($deleted) {
            return back()->with('success', 'Artisan removed from favorites successfully.');
        } else {
            return back()->with('error', 'Could not remove artisan from favorites.');
        }
    }
}
