<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Product::select('category', DB::raw('count(*) as count'))
            ->where('active', 1)
            ->groupBy('category')
            ->get();

        return view('customers.index', compact('categories'));
    }
    public function paymentIndex()
    {
        $custommer_id = Auth::id();
        $cartItems = ShoppingCart::where('customer_id', $custommer_id)->with('product')->get();

        $total = 0;
            foreach ($cartItems as $cartItem) {
                $cartItem->total = $cartItem->quantity * $cartItem->product->price;
                $total += $cartItem->total;
            }

            $tax = $total * 0.18;
            $grandTotal = $total + $tax;
            $originalPrice = $total;
            $savings = $originalPrice - $grandTotal;
            
        return view('customers.payment', compact('total', 'tax', 'grandTotal', 'originalPrice', 'savings'));
    }

    public function payment(Request $request)
    {
        // dd($request->all());

        $message = 'Ödeme basarıyla tamamlandı. Siparişiniz alındı.';

        $shoppingCart = ShoppingCart::where('customer_id', Auth::id())->get();
        foreach ($shoppingCart as $item) {
            $order = new Order();
            $order->product_id = $item->product_id;
            $order->cart_id = $item->id;
            $order->total_price = $item->product->price * $item->quantity;
            $order->status = 'confirmed';
            $order->save();
            $item->delete();
        }

        return view('customers.payment', compact('message'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
