<?php

namespace App\Services\Interfaces;

use App\Enums\FileType;

interface IFileService
{
    public function getExtension(string $filename);

    public function getFileType(string $extension);

    public function getFileSize(FileType $type);
}
