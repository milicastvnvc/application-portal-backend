<?php

namespace App\Services\Interfaces;

interface IImageCompressionService
{
    public function compressImage($file, $file_path);
}
