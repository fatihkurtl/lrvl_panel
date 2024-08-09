<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

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

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

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
        dd($product, $product_quantity);
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
