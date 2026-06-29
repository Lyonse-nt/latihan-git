<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesBase64Image
{
    /**
     * Store a base64 image from a request field.
     * Returns the stored path or null.
     */
    protected function storeBase64Image(string $base64, string $folder = 'uploads'): ?string
    {
        if (!$base64 || !str_contains($base64, 'base64,')) {
            return null;
        }

        // Extract mime and data
        preg_match('/^data:(image\/\w+);base64,/', $base64, $matches);
        $mimeType  = $matches[1] ?? 'image/jpeg';
        $extension = match ($mimeType) {
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };

        $imageData = base64_decode(substr($base64, strpos($base64, ',') + 1));
        $filename  = $folder . '/' . Str::uuid() . '.' . $extension;

        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }

    /**
     * Replace existing image with new base64 image.
     * Deletes old file if exists.
     */
    protected function replaceBase64Image(string $base64, ?string $oldPath, string $folder = 'uploads'): ?string
    {
        $newPath = $this->storeBase64Image($base64, $folder);

        if ($newPath && $oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $newPath;
    }
}
