<?php

namespace App\Services\Interfaces;

use App\Enums\FileType;

interface IStorageService
{
    public function createStoragePath(int $user_id, int $application_id, string $document_name, string $filename): string;

    public function getApplicationStoragePath(int $user_id, int $application_id): string;

    public function deleteContentsOfDirectory(string $directory_path): bool;

    public function doesExistDirectory(string $directory_path): bool;

    public function storeOnLocalDisk(mixed $file, FileType $file_type, int $user_id, int $application_id, string $document_name, string $filename): bool;

    public function getDirectory(int $user_id, int $application_id, string $document_name): string;
}
