<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use App\Models\ProductOrder;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Allow client role to access store
        $this->middleware('role:client');
    }

    /**
     * Display the store homepage with featured products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $featuredProducts = StoreProduct::where('is_featured', true)
            ->where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $categories = StoreProduct::where('is_available', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $user = Auth::user();
        $points = $user->points ? $user->points->points_balance : 0;

        return view('client.store.index', compact('featuredProducts', 'categories', 'points'));
    }

    /**
     * Display products by category.
     *
     * @param  string  $category
     * @return \Illuminate\View\View
     */
    public function category($category)
    {
        $products = StoreProduct::where('category', $category)
            ->where('is_available', true)
            ->orderBy('points_cost', 'asc')
            ->paginate(12);

        $user = Auth::user();
        $points = $user->points ? $user->points->points_balance : 0;

        return view('client.store.category', compact('products', 'category', 'points'));
    }

    /**
     * Display all available products.
     *
     * @return \Illuminate\View\View
     */
    public function allProducts()
    {
        $products = StoreProduct::where('is_available', true)
            ->orderBy('category')
            ->orderBy('points_cost')
            ->paginate(16);

        $user = Auth::user();
        $points = $user->points ? $user->points->points_balance : 0;

        return view('client.store.all', compact('products', 'points'));
    }

    /**
     * Display details of a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = StoreProduct::findOrFail($id);

        // Don't show unavailable products to clients
        if (!$product->is_available) {
            return redirect()->route('client.store.index')->with('error', 'The selected product is not available.');
        }

        $user = Auth::user();
        $points = $user->points ? $user->points->points_balance : 0;
        $canAfford = $points >= $product->points_cost;

        // Get related products from same category
        $relatedProducts = StoreProduct::where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->where('is_available', true)
            ->limit(4)
            ->get();

        return view('client.store.show', compact('product', 'points', 'canAfford', 'relatedProducts'));
    }

    /**
     * Purchase a product with points.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purchase(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'delivery_details' => 'required|string',
        ]);

        $product = StoreProduct::findOrFail($id);
        $user = Auth::user();

        // Check if product is available
        if (!$product->is_available) {
            return redirect()->back()->with('error', 'This product is no longer available.');
        }

        // Check if product is in stock
        if ($product->stock !== -1 && $request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Sorry, not enough stock available.');
        }

        // Get or create points record
        $clientPoints = ClientPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['points_balance' => 0, 'lifetime_points' => 0]
        );

        $totalCost = $product->points_cost * $request->quantity;

        // Check if user has enough points
        if ($clientPoints->points_balance < $totalCost) {
            return redirect()->back()->with('error', 'You do not have enough points for this purchase.');
        }

        // Start database transaction to ensure consistency
        DB::beginTransaction();

        try {
            // Deduct points from user
            $clientPoints->points_balance -= $totalCost;
            $clientPoints->save();

            // Create the order
            $order = ProductOrder::create([
                'user_id' => $user->id,
                'store_product_id' => $product->id,
                'quantity' => $request->quantity,
                'points_spent' => $totalCost,
                'status' => ProductOrder::STATUS_PENDING,
                'delivery_details' => $request->delivery_details
            ]);

            // Create point transaction record
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => -$totalCost,
                'type' => PointTransaction::TYPE_SPENT,
                'description' => "Purchase of {$product->name} (x{$request->quantity})",
                'transactionable_type' => ProductOrder::class,
                'transactionable_id' => $order->id
            ]);

            // Update product stock if limited
            if ($product->stock !== -1) {
                $product->stock -= $request->quantity;

                // If stock reaches 0, mark product as unavailable
                if ($product->stock <= 0) {
                    $product->is_available = false;
                }

                $product->save();
            }

            DB::commit();

            return redirect()->route('client.orders.index')
                ->with('success', "You have successfully purchased {$product->name}. Your order is being processed.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred during your purchase: ' . $e->getMessage());
        }
    }

    /**
     * Display the client's order history.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->productOrders()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.store.orders', compact('orders'));
    }

    /**
     * Display details of a specific order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function orderDetail($id)
    {
        $order = ProductOrder::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.store.order-detail', compact('order'));
    }
}
