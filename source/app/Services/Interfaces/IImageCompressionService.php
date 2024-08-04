<?php

namespace App\Services\Interfaces;

interface IImageCompressionService
{
    public function compressImage(mixed $file, string $file_path): bool;
}
