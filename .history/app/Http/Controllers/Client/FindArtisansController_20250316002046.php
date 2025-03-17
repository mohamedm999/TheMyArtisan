<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class FindArtisansController extends Controller
{
    /**
     * Display a listing of all artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Count all artisans before paginating to check if we have any
            $totalArtisans = ArtisanProfile::count();
            
            Log::info("FindArtisansController: Total artisans in database: {$totalArtisans}");
            
            // Get all artisans with their relationships
            $artisans = ArtisanProfile::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
                
            Log::info("FindArtisansController: Artisans after pagination: {$artisans->count()}");

            // If there are no artisans, add a message to the session
            if ($artisans->isEmpty()) {
                session()->flash('info', 'There are currently no artisans registered in the system.');
            }

            return view('client.find-artisans', compact('artisans'));
        } catch (\Exception $e) {
            Log::error("Error in FindArtisansController::index: " . $e->getMessage());
            session()->flash('error', 'An error occurred while loading artisans.');
            return view('client.find-artisans', ['artisans' => collect([])]);
        }
    }

    /**
     * Get all artisans data for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArtisans(Request $request)
    {
        try {
            $artisans = ArtisanProfile::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            // Return in proper paginated JSON format for the frontend
            return response()->json([
                'current_page' => $artisans->currentPage(),
                'data' => $artisans->items(),
                'first_page_url' => $artisans->url(1),
                'from' => $artisans->firstItem(),
                'last_page' => $artisans->lastPage(),
                'last_page_url' => $artisans->url($artisans->lastPage()),
                'next_page_url' => $artisans->nextPageUrl(),
                'path' => $artisans->path(),
                'per_page' => $artisans->perPage(),
                'prev_page_url' => $artisans->previousPageUrl(),
                'to' => $artisans->lastItem(),
                'total' => $artisans->total(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getArtisans: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch artisans: ' . $e->getMessage()], 500);
        }
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
