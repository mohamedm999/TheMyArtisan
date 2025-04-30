<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientPointsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of clients with their points.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'client');
        })
            ->with('points')
            ->orderBy('firstname')
            ->paginate(20);

        return view('admin.points.index', compact('clients'));
    }

    /**
     * Show the form for managing a client's points.
     *
     * @param  int  $id
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

        // Get or create client points record
        $points = $user->points ?? ClientPoint::create([
            'user_id' => $user->id,
            'points_balance' => 0,
            'lifetime_points' => 0
        ]);

        // Get transaction history
        $transactions = $user->pointTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.points.show', compact('user', 'points', 'transactions'));
    }

    /**
     * Adjust points for a client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

        // Start transaction for consistency
        DB::beginTransaction();

        try {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );

            // Determine transaction type
            $type = $request->points > 0
                ? PointTransaction::TYPE_EARNED
                : PointTransaction::TYPE_ADJUSTED;

            // Update points balance
            $clientPoints->points_balance += $request->points;

            // If adding points, also update lifetime points
            if ($request->points > 0) {
                $clientPoints->lifetime_points += $request->points;
            }

            $clientPoints->save();

            // Create transaction record
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => $request->points,
                'type' => $type,
                'description' => $request->reason,
                'transactionable_type' => User::class,
                'transactionable_id' => auth()->id()
            ]);

            DB::commit();

            $action = $request->points > 0 ? 'added to' : 'deducted from';
            $pointsAbs = abs($request->points);

            return redirect()->route('admin.points.show', $user->id)
                ->with('success', "{$pointsAbs} points {$action} {$user->firstname}'s account.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to adjust points: ' . $e->getMessage());
        }
    }

    /**
     * Display point transaction analytics.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        // Get total points in circulation
        $totalPoints = ClientPoint::sum('points_balance');

        // Get total points ever awarded
        $totalPointsAwarded = ClientPoint::sum('lifetime_points');

        // Get points awarded and spent by month for the last 6 months
        $pointsEarnedByMonth = PointTransaction::where('type', PointTransaction::TYPE_EARNED)
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(points) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $pointsSpentByMonth = PointTransaction::where('type', PointTransaction::TYPE_SPENT)
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(points) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Get top clients by lifetime points
        $topClients = ClientPoint::with('user')
            ->orderBy('lifetime_points', 'desc')
            ->limit(10)
            ->get();

        // Get clients with highest points balance
        $richestClients = ClientPoint::with('user')
            ->orderBy('points_balance', 'desc')
            ->limit(10)
            ->get();

        return view('admin.points.analytics', compact(
            'totalPoints',
            'totalPointsAwarded',
            'pointsEarnedByMonth',
            'pointsSpentByMonth',
            'topClients',
            'richestClients'
        ));
    }
}
