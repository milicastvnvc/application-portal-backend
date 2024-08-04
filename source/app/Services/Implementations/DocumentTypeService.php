<?php

namespace App\Services\Implementations;

use App\Enums\MobilityType;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IDocumentTypeRepository;
use App\Services\Interfaces\IDocumentTypeService;
use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;

class DocumentTypeService implements IDocumentTypeService
{
    private $documentTypeRepository;
    private $applicationRepository;

    public function __construct(
        IDocumentTypeRepository $documentTypeRepository,
        IApplicationRepository $applicationRepository
    ) {
        $this->documentTypeRepository = $documentTypeRepository;
        $this->applicationRepository = $applicationRepository;
    }

    public function getByMobilityType(Request $request): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application_id = $request->application_id;

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $application_id,
            $request->user(),
            relations: ['user']
        );

        if (!$application->mobility) {
            $mobility_type = MobilityType::Other;
        } else {
            $mobility_type = $application->mobility->type;
        }

        $document_types = $this->documentTypeRepository->getByMobilityType($mobility_type);

        if (!$document_types) {
            $response->setErrors(['Error while fetching document types']);
            return $response;
        }

        $result['application'] = $application;
        $result['document_types'] = $document_types;

        $response->setSuccess($result);

        return $response;
    }
}
