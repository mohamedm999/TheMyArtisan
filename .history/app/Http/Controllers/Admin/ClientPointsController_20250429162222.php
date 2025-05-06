<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use App\Models\User;
use App\Repositories\Interfaces\ClientPointsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientPointsController extends Controller
{
    /**
     * The client points repository instance.
     *
     * @var ClientPointsRepositoryInterface
     */
    protected $clientPointsRepository;

    /**
     * Create a new controller instance.
     *
     * @param ClientPointsRepositoryInterface $clientPointsRepository
     * @return void
     */
    public function __construct(ClientPointsRepositoryInterface $clientPointsRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->clientPointsRepository = $clientPointsRepository;
    }

    /**
     * Display a listing of client points.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'sort_field' => $request->sort_by,
            'sort_direction' => $request->sort_direction,
            'per_page' => $request->per_page ?? 10
        ];

        $clients = $this->clientPointsRepository->getAllClientPointsPaginated($filters);
        $stats = $this->clientPointsRepository->getPointsStatistics();

        return view('admin.points.index', compact('clients', 'stats'));
    }

    /**
     * Display the specified client point details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Ensure user is a client
        if (!$user->hasRole('client')) {
            return redirect()->route('admin.points.index')
                ->with('error', 'Selected user is not a client.');
        }

        $clientPoints = $this->clientPointsRepository->getClientPointsByUserId($id);
        $transactions = $this->clientPointsRepository->getPointTransactionsByUserId($id);

        return view('admin.points.show', compact('user', 'clientPoints', 'transactions'));
    }

    /**
     * Adjust points for a client.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adjustPoints(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|not_in:0',
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        // Ensure user is a client
        if (!$user->hasRole('client')) {
            return redirect()->route('admin.points.index')
                ->with('error', 'Selected user is not a client.');
        }

        $result = $this->clientPointsRepository->adjustPoints(
            $user,
            $request->points,
            $request->reason,
            auth()->id()
        );

        if ($result) {
            $action = $request->points > 0 ? 'added to' : 'deducted from';
            $pointsAbs = abs($request->points);

            return redirect()->route('admin.points.show', $user->id)
                ->with('success', "{$pointsAbs} points {$action} {$user->firstname}'s account.");
        } else {
            return redirect()->back()->with('error', 'Failed to adjust points. Please try again.');
        }
    }

    /**
     * Display point transaction analytics.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        $analytics = $this->clientPointsRepository->getPointsAnalytics();
        return view('admin.points.analytics', compact('analytics'));
    }
}
