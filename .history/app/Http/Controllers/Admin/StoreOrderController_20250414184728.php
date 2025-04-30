<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use App\Models\StoreProduct;
use App\Models\PointTransaction;
use App\Models\User;
use App\Services\PointsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StoreOrderController extends Controller
{
    protected $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    /**
     * Display a listing of the orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Create a base query builder
        $baseQuery = ProductOrder::query();

        // Apply filters to the base query
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        if ($request->filled('product')) {
            $baseQuery->where('store_product_id', $request->product);
        }

        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Calculate statistics based on filtered query
        // Using clones to avoid affecting the main query
        $totalOrders = (clone $baseQuery)->count();
        $pendingOrders = (clone $baseQuery)->where('status', 'pending')->count();
        $completedOrders = (clone $baseQuery)->where('status', 'completed')->count();
        $totalPointsSpent = (clone $baseQuery)->sum('points_spent');

        // Get the final paginated orders with relationships
        $orders = $baseQuery->with(['user', 'product'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        // Get products for filter dropdown
        $products = StoreProduct::orderBy('name')->get();

        return view('admin.store.orders.index', compact(
            'orders',
            'products',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalPointsSpent'
        ));
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = ProductOrder::with(['user', 'product'])->findOrFail($id);

        // Get order history from point transactions
        $orderHistory = PointTransaction::where('order_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get client's current points
        $clientPoints = $this->pointsService->getUserPoints($order->user_id);

        // Get recent points history for this client
        $pointsHistory = PointTransaction::where('user_id', $order->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.store.orders.show', compact(
            'order',
            'orderHistory',
            'clientPoints',
            'pointsHistory'
        ));
    }

    /**
     * Update order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'comment' => 'nullable|string|max:500'
        ]);

        $order = ProductOrder::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // If status is changing to cancelled, refund points
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            return $this->cancelOrder($request, $id);
        }

        // Update the order status
        $order->status = $newStatus;
        $order->save();

        // Record status change in point transactions table for history
        PointTransaction::create([
            'user_id' => $order->user_id,
            'points' => 0, // No points change, just recording status update
            'order_id' => $order->id,
            'transaction_type' => 'order_status_update',
            'status' => $newStatus,
            'description' => 'Order #' . $order->id . ' status changed to ' . $newStatus,
            'comment' => $request->comment,
            'created_by' => auth()->id()
        ]);

        // Send notification to client if needed
        if ($oldStatus != $newStatus) {
            $this->notifyStatusChange($order, $newStatus);
        }

        return redirect()->route('admin.store.orders.show', $id)
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Cancel an order and refund points to client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(Request $request, $id)
    {
        $order = ProductOrder::findOrFail($id);

        // Only allow cancellation of non-cancelled orders
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.store.orders.show', $id)
                ->with('error', 'Order is already cancelled.');
        }

        DB::beginTransaction();
        try {
            // Update order status
            $order->status = 'cancelled';
            $order->save();

            // Refund points to client
            $pointsToRefund = $order->points_spent;
            $this->pointsService->addPoints(
                $order->user_id,
                $pointsToRefund,
                'Refund for cancelled order #' . $order->id,
                'order_refund',
                $order->id,
                'cancelled',
                $request->comment ?? 'Order cancelled by admin'
            );

            DB::commit();

            // Send notification email
            $this->notifyOrderCancelled($order);

            return redirect()->route('admin.store.orders.show', $id)
                ->with('success', 'Order cancelled and ' . number_format($pointsToRefund) . ' points refunded to client.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.store.orders.show', $id)
                ->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    /**
     * Mark an order as completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completeOrder(Request $request, $id)
    {
        $order = ProductOrder::findOrFail($id);

        // Only allow completion of non-completed orders
        if ($order->status === 'completed') {
            return redirect()->route('admin.store.orders.show', $id)
                ->with('error', 'Order is already marked as completed.');
        }

        // Update order status
        $order->status = 'completed';
        $order->save();

        // Record status change
        PointTransaction::create([
            'user_id' => $order->user_id,
            'points' => 0, // No points change, just recording status update
            'order_id' => $order->id,
            'transaction_type' => 'order_status_update',
            'status' => 'completed',
            'description' => 'Order #' . $order->id . ' marked as completed',
            'created_by' => auth()->id()
        ]);

        // Send notification email
        $this->notifyOrderCompleted($order);

        return redirect()->route('admin.store.orders.show', $id)
            ->with('success', 'Order marked as completed.');
    }

    /**
     * Update admin notes for an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAdminNotes(Request $request, $id)
    {
        $request->validate([
            'notes_admin' => 'nullable|string|max:2000',
        ]);

        $order = ProductOrder::findOrFail($id);
        $order->notes_admin = $request->notes_admin;
        $order->save();

        return redirect()->route('admin.store.orders.show', $id)
            ->with('success', 'Admin notes updated successfully.');
    }

    /**
     * Show email form to contact the client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEmailForm($id)
    {
        $order = ProductOrder::with(['user', 'product'])->findOrFail($id);

        return view('admin.store.orders.email', compact('order'));
    }

    /**
     * Send email to client about their order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $order = ProductOrder::with('user')->findOrFail($id);

        // Send email
        Mail::send('emails.order-notification', [
            'order' => $order,
            'message' => $request->message,
        ], function ($mail) use ($order, $request) {
            $mail->to($order->user->email, $order->user->firstname . ' ' . $order->user->lastname)
                ->subject($request->subject);
        });

        // Log this communication
        PointTransaction::create([
            'user_id' => $order->user_id,
            'points' => 0,
            'order_id' => $order->id,
            'transaction_type' => 'communication',
            'status' => $order->status,
            'description' => 'Email sent regarding order #' . $order->id . ': ' . $request->subject,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.store.orders.show', $id)
            ->with('success', 'Email sent to client successfully.');
    }

    /**
     * Send notification about order status change.
     *
     * @param  \App\Models\ProductOrder  $order
     * @param  string  $status
     * @return void
     */
    private function notifyStatusChange($order, $status)
    {
        // Implementation would depend on your notification system
        // Could send email, push notification, etc.

        // This is just a placeholder for future implementation
        if (in_array($status, ['processing', 'shipped'])) {
            // Could send notification email here
        }
    }

    /**
     * Send notification about order cancellation.
     *
     * @param  \App\Models\ProductOrder  $order
     * @return void
     */
    private function notifyOrderCancelled($order)
    {
        // Implementation would depend on your notification system
        // This is just a placeholder for future implementation
    }

    /**
     * Send notification about order completion.
     *
     * @param  \App\Models\ProductOrder  $order
     * @return void
     */
    private function notifyOrderCompleted($order)
    {
        // Implementation would depend on your notification system
        // This is just a placeholder for future implementation
    }
}
