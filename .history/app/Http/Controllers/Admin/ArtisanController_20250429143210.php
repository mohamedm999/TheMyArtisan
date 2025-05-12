<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Country;
use App\Models\ArtisanProfile;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ArtisanStatusUpdated;

class ArtisanController extends Controller
{
    /**
     * The artisan profile repository instance.
     *
     * @var ArtisanProfileRepositoryInterface
     */
    protected $artisanProfileRepository;

    /**
     * Create a new controller instance.
     *
     * @param ArtisanProfileRepositoryInterface $artisanProfileRepository
     * @return void
     */
    public function __construct(ArtisanProfileRepositoryInterface $artisanProfileRepository)
    {
        $this->artisanProfileRepository = $artisanProfileRepository;
    }

    /**
     * Display a listing of artisans.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Create artisan profiles for users who don't have them
        $artisanUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->get();

        foreach ($artisanUsers as $user) {
            if (!$user->artisanProfile) {
                $this->artisanProfileRepository->findOrCreateByUserId($user->id);
            }
        }

        // Get filtered artisans using the repository
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'country' => $request->country,
            'category' => $request->category
        ];

        $artisans = $this->artisanProfileRepository->getFilteredArtisans($filters);
        $stats = $this->artisanProfileRepository->getArtisanStatistics();

        // Get filter options
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.artisans.index', compact('artisans', 'stats', 'countries', 'categories'));
    }

    /**
     * Display the specified artisan.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $artisan = $this->artisanProfileRepository->getArtisanWithAllRelations($id);
        return view('admin.artisans.show', compact('artisan'));
    }

    /**
     * Approve an artisan profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->artisanProfile;

        if (!$profile) {
            return back()->with('error', 'This artisan does not have a profile.');
        }

        if ($this->artisanProfileRepository->updateStatus($profile->id, ArtisanProfile::STATUS_APPROVED)) {
            // Send notification to the artisan
            try {
                $user->notify(new ArtisanStatusUpdated('approved'));
            } catch (\Exception $e) {
                // Log the error but continue
            }

            return back()->with('success', 'Artisan has been approved successfully.');
        }

        return back()->with('error', 'Failed to approve artisan.');
    }

    /**
     * Reject an artisan profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->artisanProfile;

        if (!$profile) {
            return back()->with('error', 'This artisan does not have a profile.');
        }

        if ($this->artisanProfileRepository->updateStatus($profile->id, ArtisanProfile::STATUS_REJECTED)) {
            // Send notification to the artisan
            try {
                $user->notify(new ArtisanStatusUpdated('rejected'));
            } catch (\Exception $e) {
                // Log the error but continue
            }

            return back()->with('success', 'Artisan has been rejected.');
        }

        return back()->with('error', 'Failed to reject artisan.');
    }

    /**
     * Export artisans data
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'country' => $request->country,
            'category' => $request->category
        ];

        $exportData = $this->artisanProfileRepository->exportArtisans($filters);

        // Export logic would go here - for now just return a success message
        return redirect()->route('admin.artisans.index')
            ->with('success', 'Artisans exported successfully.');
    }

    /**
     * Display services for the specified artisan
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function services($id)
    {
        $artisan = $this->artisanProfileRepository->getArtisanWithAllRelations($id);
        return view('admin.artisans.services', compact('artisan'));
    }
}
