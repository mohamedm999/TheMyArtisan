<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('role:client');
    }

    /**
     * Display the client's points information.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $points = $user->points ?? ClientPoint::create([
            'user_id' => $user->id,
            'points_balance' => 0,
            'lifetime_points' => 0
        ]);

        // Get recent transactions
        $transactions = $user->pointTransactions()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('client.points.index', compact('user', 'points', 'transactions'));
    }

    /**
     * Display the client's point transaction history.
     *
     * @return \Illuminate\View\View
     */
    public function transactions()
    {
        $user = Auth::user();
        $transactions = $user->pointTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('client.points.transactions', compact('user', 'transactions'));
    }

    /**
     * Add points to a client (admin function).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPoints(Request $request, $userId)
    {
        // Check if admin or authorized person
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate request
        $request->validate([
            'points' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $user = \App\Models\User::findOrFail($userId);

        // Find or create client points record
        $clientPoints = ClientPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['points_balance' => 0, 'lifetime_points' => 0]
        );

        // Add points
        $clientPoints->points_balance += $request->points;
        $clientPoints->lifetime_points += $request->points;
        $clientPoints->save();

        // Create transaction record
        PointTransaction::create([
            'user_id' => $user->id,
            'points' => $request->points,
            'type' => PointTransaction::TYPE_EARNED,
            'description' => $request->reason,
            'transactionable_type' => 'App\Models\User',
            'transactionable_id' => Auth::id() // Admin who added the points
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully added {$request->points} points to user's account",
            'new_balance' => $clientPoints->points_balance,
        ]);
    }
}
