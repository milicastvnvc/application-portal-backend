<?php

namespace App\Services\Implementations;

use App\Enums\ApplicationStatus;
use App\Enums\FormProgress;
use App\Enums\MobilityType;
use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IDocumentTypeRepository;
use App\Repositories\Interfaces\IUploadedDocumentsRepository;
use App\Services\Interfaces\IFileService;
use App\Services\Interfaces\IStorageService;
use App\Services\Interfaces\IUploadedDocumentsService;
use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use ZipArchive;

class UploadedDocumentsService implements IUploadedDocumentsService
{
    private $uploadedDocumentsRepository;
    private $applicationRepository;
    private $documentTypeRepository;
    private $applicationProgressRepository;
    private $fileService;
    private $storageService;

    public function __construct(
        IUploadedDocumentsRepository $uploadedDocumentsRepository,
        IDocumentTypeRepository $documentTypeRepository,
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository,
        IFileService $fileService,
        IStorageService $storageService
    ) {
        $this->uploadedDocumentsRepository = $uploadedDocumentsRepository;
        $this->documentTypeRepository = $documentTypeRepository;
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
        $this->fileService = $fileService;
        $this->storageService = $storageService;
    }

    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $this->applicationRepository->getApplicationByIdAndUser($application_id, $user);

        $documents = $this->uploadedDocumentsRepository->getDocumentsByApplication($application_id);

        if (!$documents) {
            $response->setErrors(['Documents for this application does not exist']);
            return $response;
        }

        $response->setSuccess($documents);

        return $response;
    }

    public function createOrUpdate(Request $request): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $document_type = $this->documentTypeRepository->findById($request->document_type_id);

        if (!$document_type) {
            $response->setErrors(['Invalid document type']);
            return $response;
        }

        $validator = $this->validate($request->all(), $document_type->file_formats);

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $request->application_id,
            $request->user(),
            relations: ['application_progress'],
            adminAccess: false
        );

        $forms = config('constant.FormsInfo');
        if (!ApplicationHelper::checkCanYouModify($application, $forms['documents-upload'])) {
            $response->setErrors(['You cannot change this form, it\'s locked.']);
            return $response;
        }

        $videoDocument = config('constant.VideoDocument');
        if ($videoDocument == $request->document_name) {
            $originalName = "video";
            $path = $request->link;
        }
        else {
            $id = $request->user()->id;
            $originalName = $request->file('file')->getClientOriginalName();
            $document_name = $request->document_name;
            $extension = $this->fileService->getExtension($originalName);
            $file_type = $this->fileService->getFileType($extension);

            $directory = $this->storageService->getDirectory($id, $application->id, $document_name);

            $isSuccessfullyDeleted = $this->storageService->deleteContentsOfDirectory($directory);

            $isSuccessful = $this->storageService->storeOnLocalDisk($request->file('file'), $file_type, $id, $application->id, $document_name, $originalName);

            if (!$isSuccessful || !$isSuccessfullyDeleted) {
                $response->setErrors(['Error while storing document.']);
                return $response;
            }
            $path = $directory . DIRECTORY_SEPARATOR . $originalName;
        }

        try {
            DB::beginTransaction();

            $document = $this->uploadedDocumentsRepository->updateOrCreate(
                ['application_id' => $application->id, 'document_type_id' => $request->document_type_id],
                [
                    'application_id' => $request->application_id,
                    'document_type_id' => $request->document_type_id,
                    'path' => $path,
                    'filename' => $originalName
                ]
            );

            if ($document === null) {
                $response->setErrors(['Error while changing document.']);
                throw new \Exception("Error while changing document.");
            }

            if ($application->application_progress->documents_upload == FormProgress::Incompleted) {
                $count_my_documents = $this->uploadedDocumentsRepository->countDocumentsByApplication($application->id);
                if (!$application->mobility) {
                    $mobility_type = MobilityType::Other;
                } else $mobility_type = $application->mobility->type;

                $count_required_documents = $this->documentTypeRepository->countDocumentsByMobilityType($mobility_type);

                if ($count_my_documents >= $count_required_documents) {
                    $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                        "documents_upload" => FormProgress::Completed
                    ]);

                    if (!$progress) {
                        $response->setErrors(['Error while changing document']);
                        throw new \Exception("Error while changing document");
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors))
                $response->setErrors([$e->getMessage()]);
            return $response;
        }

        $response->setSuccess($document);

        return $response;
    }

    public function download(Request $request): null|string
    {
        $application = $this->applicationRepository->getApplicationByIdAndUser($request->application_id, $request->user());

        $file_path = $this->storageService->createStoragePath(
            $application->user_id,
            $request->application_id,
            $request->document_name,
            $request->filename
        );

        if (file_exists($file_path)) {
            return $file_path;
        } else {
            return null;
        }
    }

    public function downloadAll(Request $request): null|string
    {
        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $request->application_id,
            $request->user()
        );

        if ($application->status == ApplicationStatus::Created)
        {
            return null;
        }

        $documents = $this->uploadedDocumentsRepository->getDocumentsByApplication($application->id, ['document_type']);
        //$output = new \Symfony\Component\Console\Output\ConsoleOutput();

        $zip = new ZipArchive();
        $zipFileName = 'example.zip';

        $zip_path = $this->storageService->getApplicationStoragePath(
            $application->user_id,
            $request->application_id
        ) . DIRECTORY_SEPARATOR . $zipFileName;

        if ($zip->open($zip_path, ZipArchive::CREATE) === TRUE) {

            foreach ($documents as $document) {
                $filepath = storage_path() . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . $document->path;
                if (file_exists($filepath))
                {
                    $filename = $document->document_type->name . ' - ' .  $document->filename;
                    $zip->addFile($filepath, $filename);
                }

            }

            $zip->close();
        }

        if (file_exists($zip_path)) {
            return $zip_path;
        } else {
            return null;
        }
    }

    public function validate(mixed $input_data, string $file_formats): Val
    {

        $validator = Validator::make($input_data, [
            'application_id' =>  'required|numeric',
            'document_type_id' =>  'required|numeric',
            'document_name' => 'required|string',
            'filename' => 'required|string'
        ]);

        if ($validator->fails()) return $validator;

        $videoDocument = config('constant.VideoDocument');
        if ($videoDocument == $input_data['document_name']) {
            $validator = Validator::make($input_data, [
                'link' => 'required|url'
            ]);
            return $validator;
        }

        $extension = $this->fileService->getExtension($input_data['file']->getClientOriginalName());
        $file_type = $this->fileService->getFileType($extension);
        $delimiter = config('constant.FileFormatsDelimiter');
        $allFormats = explode($delimiter, $file_formats);
        $file_size = $this->fileService->getFileSize($file_type);

        $validator = Validator::make($input_data, [
            'file' => [
                'required',
                File::types($allFormats)
                    ->max($file_size * 1024)
            ]
        ]);

        return $validator;
    }
}
