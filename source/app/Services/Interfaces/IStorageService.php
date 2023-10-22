<?php

namespace App\Services\Interfaces;

interface IStorageService
{
    public function createStoragePath($user_id, $application_id, $document_name, $filename);

    public function deleteContentsOfDirectory($directory_path);

    public function doesExistDirectory($directory_path);

    public function storeOnLocalDisk($file, $file_type, $user_id, $application_id, $document_name, $filename);

    public function getDirectory($user_id, $application_id, $document_name);

    public function convertBytesToMegabytes($bytes);
}
