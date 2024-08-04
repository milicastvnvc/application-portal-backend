<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\IImageCompressionService;
use Intervention\Image\Facades\Image;

class ImageCompressionService implements IImageCompressionService
{
    public function compressImage(mixed $file, string $file_path): bool
    {
        $isSuccessful = false;

        $img = Image::make(file_get_contents($file));

        $height = $img->height();
        $width = $img->width();
        $resizePixelsLimit = config('constant.ResizePixelsLimit');

        if ($height > $resizePixelsLimit || $width > $resizePixelsLimit) {
            $resizeRate = config('constant.ResizeRate');

            $img->resize($width / $resizeRate, $height / $resizeRate, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $quality = config('constant.ImageCompressionQuality');

        $img = $img->save($file_path, $quality, 'jpg');

        if ($img) $isSuccessful = true;

        return $isSuccessful;
    }
}
