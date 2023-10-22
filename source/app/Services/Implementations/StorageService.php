<?php

namespace App\Services\Implementations;

use App\Enums\FileType;
use App\Services\Interfaces\IImageCompressionService;
use App\Services\Interfaces\IStorageService;
use App\Services\Interfaces\IVideoCompressionService;
use Illuminate\Support\Facades\Storage;

class StorageService implements IStorageService
{

    private $imageCompressionService;
    private $videoCompressionService;

    public function __construct(IImageCompressionService $imageCompressionService, IVideoCompressionService $videoCompressionService)
    {
        $this->imageCompressionService = $imageCompressionService;
        $this->videoCompressionService = $videoCompressionService;
    }

    public function createStoragePath($user_id, $application_id, $document_name, $filename)
    {
        $file_path = storage_path() . DIRECTORY_SEPARATOR . 'app'  . DIRECTORY_SEPARATOR .  $user_id .  DIRECTORY_SEPARATOR . $application_id . DIRECTORY_SEPARATOR . $document_name . DIRECTORY_SEPARATOR . $filename;

        return $file_path;
    }

    public function deleteContentsOfDirectory($directory_path)
    {
        $result = true;

        if ($this->doesExistDirectory($directory_path)) {
            $files =   Storage::allFiles($directory_path);
            $result = Storage::delete($files);
        }

        return $result;
    }

    public function doesExistDirectory($directory_path)
    {

        if (Storage::exists($directory_path) && is_dir(Storage::path($directory_path))) {
            return true;
        }

        return false;
    }

    public function storeOnLocalDisk($file, $file_type, $user_id, $application_id, $document_name, $filename)
    {
        $directory = $this->getDirectory($user_id, $application_id, $document_name);
        $isSuccessful = false;

        // $fileSize = $this->convertBytesToMegabytes($file->getSize());
        // $resizeLimit = config('constant.ResizeLimit');

        if ($file_type == FileType::Image) {

            $file_path = $this->createStoragePath(
                $user_id,
                $application_id,
                $document_name,
                $filename
            );

            if (!$this->doesExistDirectory($directory)) Storage::makeDirectory($directory);

            $isSuccessful = $this->imageCompressionService->compressImage($file, $file_path);

            return $isSuccessful;
        }
        else if ($file_type == FileType::Video) {

            $file_path = $this->createStoragePath(
                $user_id,
                $application_id,
                $document_name,
                $filename
            );

            $isSuccessful = $this->videoCompressionService->compressVideo($file, $directory);
            return $isSuccessful;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        $isSuccessful = Storage::disk('local')->put($path, file_get_contents($file));

        return $isSuccessful;
    }

    public function getDirectory($user_id, $application_id, $document_name)
    {
        return  $user_id . DIRECTORY_SEPARATOR . $application_id . DIRECTORY_SEPARATOR . $document_name;
    }

    public function convertBytesToMegabytes($bytes)
    {
        return $bytes / 1048576;
    }
}
