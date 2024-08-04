<?php

namespace App\Services\Interfaces;

use App\Enums\FileType;

interface IFileService
{
    public function getExtension(string $filename): string;

    public function getFileType(string $extension): FileType;

    public function getFileSize(FileType $type): int;
}
