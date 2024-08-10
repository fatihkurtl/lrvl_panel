<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function productDetailIndex(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        return view('customers.productDetail', compact('product'));
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Product::where('active', 1);

        if ($request->has('kategori') && !empty($request->input('kategori'))) {
            $query->whereIn('category', $request->input('kategori'));
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = Product::select('category', DB::raw('count(*) as count'))
            ->where('active', 1)
            ->groupBy('category')
            ->get();

        return view('customers.store', compact('products', 'categories'));
    }

    public function addCart(Request $request)
    {
        $product = $request->input('product_id');
        $product_quantity = $request->input('quantity');

        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'customer_id' => 'nullable',
        ]);

        $customer = $request->has('customer_id') && !empty($request->input('customer_id'))
            ? Customer::findOrFail($request->input('customer_id'))
            : null;

        $shoppingCartItem = ShoppingCart::where('product_id', $product)
            ->where('customer_id', $customer->id ?? null)
            ->first();

        if ($shoppingCartItem) {
            $shoppingCartItem->quantity += $product_quantity;
            $shoppingCartItem->save();
        } else {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->product_id = $product;
            $shoppingCart->quantity = $product_quantity;
            $shoppingCart->customer_id = $customer->id ?? null;
            $shoppingCart->save();
        }

        return redirect()->route('customers-store')->with('success', 'Ürün sepete eklendi.');
    }

    public function getCartItems()
    {
        if (!Auth::check()) {
            $custommer_id = Auth::id();
            $cartItems = ShoppingCart::where('customer_id', $custommer_id)->with('product')->get();
            return response()->json(['cartItems' => $cartItems], 200);
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
