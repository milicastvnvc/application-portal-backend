<?php

namespace App\Services\Implementations;

use App\Enums\FileType;
use App\Services\Interfaces\IFileService;

class FileService implements IFileService
{

    public function getExtension(string $filename)
    {
        $delimiter = '.';
        $nameArray =  explode($delimiter, $filename);
        $extension = end($nameArray);

        return $extension;
    }

    public function getFileType(string $extension)
    {
        $videoFormats = config('constant.VideoFormats');
        $imageFormats = config('constant.ImageFormats');
        $documentFormats = config('constant.DocumentFormats');

        if (strpos($imageFormats, $extension) !== false) {
            return FileType::Image;
        }

        if (strpos($documentFormats, $extension) !== false) {
            return FileType::Document;
        }

        if (strpos($videoFormats, $extension) !== false) {
            return FileType::Video;
        }

        return FileType::Other;
    }

    public function getFileSize(FileType $type)
    {
        $fileSize = config('constant.FileSize');
        $videoSize = config('constant.VideoSize');

        switch ($type) {
            case FileType::Video:
                return $videoSize;
            default:
                return $fileSize;
        }
    }
}
