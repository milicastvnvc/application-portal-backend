<?php

namespace App\Services\Implementations;

use App\Enums\FileType;
use App\Services\Interfaces\IImageCompressionService;
use App\Services\Interfaces\IStorageService;
use Illuminate\Support\Facades\Storage;

class StorageService implements IStorageService
{

    private $imageCompressionService;

    public function __construct(IImageCompressionService $imageCompressionService)
    {
        $this->imageCompressionService = $imageCompressionService;
    }

    public function createStoragePath(int $user_id, int $application_id, string $document_name, string $filename): string
    {
        $file_path = $this->getApplicationStoragePath($user_id, $application_id) .  DIRECTORY_SEPARATOR . $application_id . DIRECTORY_SEPARATOR . $document_name . DIRECTORY_SEPARATOR . $filename;

        return $file_path;
    }

    public function getApplicationStoragePath(int $user_id, int $application_id): string
    {
        $file_path = storage_path() . DIRECTORY_SEPARATOR . 'app'  . DIRECTORY_SEPARATOR .  $user_id;

        return $file_path;
    }

    public function deleteContentsOfDirectory(string $directory_path): bool
    {
        $result = true;

        if ($this->doesExistDirectory($directory_path)) {
            $files =   Storage::allFiles($directory_path);
            $result = Storage::delete($files);
        }

        return $result;
    }

    public function doesExistDirectory(string $directory_path): bool
    {

        if (Storage::exists($directory_path) && is_dir(Storage::path($directory_path))) {
            return true;
        }

        return false;
    }

    public function storeOnLocalDisk(mixed $file, FileType $file_type, int $user_id, int $application_id, string $document_name, string $filename): bool
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

        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        $isSuccessful = Storage::disk('local')->put($path, file_get_contents($file));

        return $isSuccessful;
    }

    public function getDirectory(int $user_id, int $application_id, string $document_name): string
    {
        return  $user_id . DIRECTORY_SEPARATOR . $application_id . DIRECTORY_SEPARATOR . $document_name;
    }
}
