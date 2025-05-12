<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreProductController extends Controller
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
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = StoreProduct::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.store.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get unique categories for dropdown
        $categories = StoreProduct::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('admin.store.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'points_cost' => 'required|integer|min:1',
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048', // 2MB max
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1', // -1 means unlimited
        ]);

        $product = new StoreProduct();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->points_cost = $request->points_cost;
        $product->category = $request->category;
        $product->is_featured = $request->has('is_featured');
        $product->is_available = $request->has('is_available');
        $product->stock = $request->stock;

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.store.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = StoreProduct::findOrFail($id);

        // Get recent orders for this product
        $orders = ProductOrder::where('store_product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.store.products.show', compact('product', 'orders'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = StoreProduct::findOrFail($id);

        // Get unique categories for dropdown
        $categories = StoreProduct::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('admin.store.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'points_cost' => 'required|integer|min:1',
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048', // 2MB max
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'stock' => 'required|integer|min:-1', // -1 means unlimited
        ]);

        $product = StoreProduct::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->points_cost = $request->points_cost;
        $product->category = $request->category;
        $product->is_featured = $request->has('is_featured');
        $product->is_available = $request->has('is_available');
        $product->stock = $request->stock;

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.store.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = StoreProduct::findOrFail($id);

        // Check if there are any existing orders for this product
        $orderCount = ProductOrder::where('store_product_id', $product->id)->count();

        if ($orderCount > 0) {
            return redirect()->route('admin.store.products.index')
                ->with('error', 'Cannot delete product with existing orders. Consider marking it as unavailable instead.');
        }

        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.store.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Display all orders for store products.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $orders = ProductOrder::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.store.orders.index', compact('orders'));
    }

    /**
     * Display details of a specific order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function orderShow($id)
    {
        $order = ProductOrder::with(['user', 'product', 'pointTransaction'])
            ->findOrFail($id);

        return view('admin.store.orders.show', compact('order'));
    }

    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,refunded',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $order = ProductOrder::findOrFail($id);
        $originalStatus = $order->status;

        // Handle refund if changing to refunded
        if ($request->status === ProductOrder::STATUS_REFUNDED && $originalStatus !== ProductOrder::STATUS_REFUNDED) {
            // Start transaction for consistency
            \DB::beginTransaction();

            try {
                // Refund points to user
                $clientPoints = $order->user->points;
                if ($clientPoints) {
                    $clientPoints->points_balance += $order->points_spent;
                    $clientPoints->save();

                    // Create transaction record for refund
                    \App\Models\PointTransaction::create([
                        'user_id' => $order->user_id,
                        'points' => $order->points_spent, // Positive value for refund
                        'type' => \App\Models\PointTransaction::TYPE_REFUNDED,
                        'description' => "Refund for order #{$order->id} ({$order->product->name})",
                        'transactionable_type' => ProductOrder::class,
                        'transactionable_id' => $order->id
                    ]);
                }

                // Update order status
                $order->status = $request->status;
                $order->tracking_number = $request->tracking_number;
                $order->save();

                \DB::commit();

                return redirect()->route('admin.store.orders.show', $order->id)
                    ->with('success', 'Order refunded successfully and points returned to customer.');
            } catch (\Exception $e) {
                \DB::rollBack();
                return redirect()->back()->with('error', 'Failed to process refund: ' . $e->getMessage());
            }
        } else {
            // Simple status update
            $order->status = $request->status;
            $order->tracking_number = $request->tracking_number;
            $order->save();

            return redirect()->route('admin.store.orders.show', $order->id)
                ->with('success', 'Order status updated successfully.');
        }
    }
}
