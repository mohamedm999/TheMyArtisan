<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['client', 'artisan', 'service']);

        // Filter by artisan if provided
        if ($request->has('artisan_id')) {
            $query->whereHas('artisanProfile', function ($q) use ($request) {
                $q->where('user_id', $request->artisan_id);
            });
        }

        // Filter by client if provided
        if ($request->has('client_id')) {
            $query->whereHas('clientProfile', function ($q) use ($request) {
                $q->where('user_id', $request->client_id);
            });
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['client.clientProfile', 'artisan.artisanProfile', 'service', 'review'])
            ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}
