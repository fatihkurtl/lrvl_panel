<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ValidationHelper
{
    public static function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'color' => 'nullable|string|max:255',
            'description' => 'required|string',
            'active' => 'required|boolean',
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad alanı 255 karakterden fazla olmamalıdır.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat alanı rakam olmalıdır.',
            'brand.required' => 'Marka alanı zorunludur.',
            'category.required' => 'Kategori alanı zorunludur.',
            'category.max' => 'Kategori alanı 255 karakterden fazla olmamalıdır.',
            'weight.required' => 'Agırlık alanı zorunludur.',
            'stock.required' => 'Stok alanı zorunludur.',
            'color.max' => 'Renk alanı 255 karakterden fazla olmamalıdır.',
            'description.required' => 'Acıklama alanı zorunludur.',
            'image.mimes' => 'Yüklenen resim jpeg, png, jpg, gif, svg uzantılı olmalıdır.',
            'image.max' => 'Yüklenen resim 2 MB den fazla olmamalıdır.',
            'active.required' => 'Durum alanı zorunludur.',
        ]);
    }
}
