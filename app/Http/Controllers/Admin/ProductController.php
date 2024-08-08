<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ValidationHelper;
use App\Services\ImageUploadService;

class ProductController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }
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
        ValidationHelper::validateProduct($request);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->imageUploadService->imageUpload($request->file('image'));
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

        return redirect()->route('admin-create-product')->with('success', 'Ürün başarıyla oluşturuldu.');
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
        ValidationHelper::validateProduct($request);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;

        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('products', 'public');

        //     if (file_exists(public_path($product->image))) {
        //         unlink(public_path($product->image));
        //     }
        // }
        
        if ($request->hasFile('image')) {
            $imagePath = $this->imageUploadService->imageUpload($request->file('image'), $product->image);
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

        return redirect()->route('admin-edit-product', ['product' => $product->id])->with('success', 'Ürün güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
