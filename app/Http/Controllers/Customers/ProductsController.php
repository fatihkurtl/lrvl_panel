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
        return view('customers.productDetail');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('active', 1);

        // Check if any categories are selected
        if ($request->has('kategori') && !empty($request->input('kategori'))) {
            $query->whereIn('category', $request->input('kategori'));
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get all categories and their respective product counts
        $categories = Product::select('category', DB::raw('count(*) as count'))
            ->where('active', 1)
            ->groupBy('category')
            ->get();

        return view('customers.store', compact('products', 'categories'));
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
