<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{

    public const PRODUCT_IMAGE_PATH ='products';

    /**
     * Upload the image to storage and return the path.
     * 
     * 
     * @param UploadedFile $image
     * @param string|null $existingImagePath
     * @return string
     */
    public function imageUpload(UploadedFile $image, string $existingImagePath = null): string
    {
        if ($existingImagePath && Storage::disk('public')->exists($existingImagePath)) {
            Storage::disk('public')->delete($existingImagePath);
        }
        return $image->store(self::PRODUCT_IMAGE_PATH, 'public');
    }
}