<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
            $unPaginatedProducts = Product::orderBy('created_at', 'desc')->get();
            return view('admin.products', compact('products', 'unPaginatedProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.createProduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'color' => 'nullable|string|max:255',
            'description' => 'required|string',
            'active' => 'required|boolean',
        ], [
            'image.mimes' => 'Yüklenen resim jpeg, png, jpg, gif, svg uzantılı olmalıdır.',
            'image.max' => 'Yüklenen resim 2 MB den fazla olmamalıdır.',
            'image.required' => 'Yüklenen resim mevcut olmalıdır.',
            'active.required' => 'Durum alanı zorunludur.',
        ]);

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'image' => $imagePath,
            'brand' => $request->brand,
            'price' => $request->price,
            'category' => $request->category,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'color' => $request->color,
            'description' => $request->description,
            'active' => $request->active,
        ]);

        return redirect()->route('create-product')->with('success', 'Ürün başarıyla oluşturuldu.');
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
        $product = Product::find($id);
        return view('admin.editProduct', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'color' => 'nullable|string|max:255',
            'description' => 'required|string',
            'active' => 'required|boolean',
        ], [
            'image.mimes' => 'Yüklenen resim jpeg, png, jpg, gif, svg uzantılı olmalıdır.',
            'image.max' => 'Yüklenen resim 2 MB den fazla olmamalıdır.',
            'active.required' => 'Durum alanı zorunludur.',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');

            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
        }

        $product->update([
            'name' => $request->name,
            'image' => $imagePath,
            'brand' => $request->brand,
            'price' => $request->price,
            'category' => $request->category,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'color' => $request->color,
            'description' => $request->description,
            'active' => $request->active,
        ]);

        return redirect()->route('edit-product', ['product' => $product->id])->with('success', 'Ürün güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
