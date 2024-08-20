<?php

namespace App\Http\Controllers\Customers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
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

            return response()->json([
                'cartItems' => $cartItems,
                'cartSummary' => [
                    'total' => $total,
                    'tax' => $tax,
                    'grandTotal' => $grandTotal,
                    'originalPrice' => $originalPrice,
                    'savings' => $savings
                ]
            ], 200);
        } else {
            return response()->json(['message' => 'Giriş yapmadınız.'], 401);
        }
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
        if ($request->input('type') == 'increment' && $id) {
            $cartItem = ShoppingCart::findOrFail($id);
            $cartItem->quantity += 1;
            $cartItem->save();
            return response()->json(['message' => 'Ürün miktarı güncellendi.'], 200);
        } elseif ($request->input('type') == 'decrement' && $id) {
            $cartItem = ShoppingCart::findOrFail($id);
            if ($cartItem->quantity == 1) {
                $cartItem->delete();
                return response()->json(['message' => 'Ürün sepetten kaldırıldı.'], 200);
            } else {
                $cartItem->quantity -= 1;
                $cartItem->save();
                return response()->json(['message' => 'Ürün miktarı güncellendi.'], 200);
            }
        } else {
            return response()->json(['message' => 'Ürün miktarı güncellenemedi.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($id) {
            $deleted = ShoppingCart::where('id', $id)->delete();
            return response()->json(['deleted' => $deleted], 200);
        }

        return response()->json(['deleted' => false], 400);
    }
}
