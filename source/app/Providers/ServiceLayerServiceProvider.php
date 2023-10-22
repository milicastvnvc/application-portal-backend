<?php

namespace App\Providers;

use App\Services\Implementations\ApplicationProgressService;
use App\Services\Implementations\ApplicationService;
use App\Services\Implementations\DocumentTypeService;
use App\Services\Implementations\GoogleService;
use App\Services\Implementations\FileService;
use App\Services\Implementations\HomeInstitutionFormService;
use App\Services\Implementations\HomeInstitutionService;
use App\Services\Implementations\ImageCompressionService;
use App\Services\Implementations\MobilityService;
use App\Services\Implementations\MotivationAndAddedValueService;
use App\Services\Implementations\PersonalDetailsService;
use App\Services\Implementations\ProposedHostUniversitiesService;
use App\Services\Implementations\StorageService;
use App\Services\Implementations\UnlockedFormService;
use App\Services\Implementations\UploadedDocumentsService;
use App\Services\Implementations\UserService;
use App\Services\Implementations\VideoCompressionService;
use App\Services\Interfaces\IApplicationProgressService;
use App\Services\Interfaces\IApplicationService;
use App\Services\Interfaces\IDocumentTypeService;
use App\Services\Interfaces\IFileService;
use App\Services\Interfaces\IGoogleService;
use App\Services\Interfaces\IHomeInstitutionFormService;
use App\Services\Interfaces\IHomeInstitutionService;
use App\Services\Interfaces\IImageCompressionService;
use App\Services\Interfaces\IMobilityService;
use App\Services\Interfaces\IMotivationAndAddedValueService;
use App\Services\Interfaces\IPersonalDetailsService;
use App\Services\Interfaces\IProposedHostUniversitiesService;
use App\Services\Interfaces\IStorageService;
use App\Services\Interfaces\IUnlockedFormService;
use App\Services\Interfaces\IUploadedDocumentsService;
use App\Services\Interfaces\IUserService;
use App\Services\Interfaces\IVideoCompressionService;
use Illuminate\Support\ServiceProvider;

class ServiceLayerServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IUserService::class => UserService::class,
        IGoogleService::class => GoogleService::class,
        IStorageService::class => StorageService::class,
        IImageCompressionService::class => ImageCompressionService::class,
        IVideoCompressionService::class => VideoCompressionService::class,
        IFileService::class => FileService::class,
        IApplicationService::class => ApplicationService::class,
        IHomeInstitutionService::class => HomeInstitutionService::class,
        IApplicationProgressService::class => ApplicationProgressService::class,
        IMobilityService::class => MobilityService::class,
        IPersonalDetailsService::class => PersonalDetailsService::class,
        IHomeInstitutionFormService::class => HomeInstitutionFormService::class,
        IProposedHostUniversitiesService::class => ProposedHostUniversitiesService::class,
        IMotivationAndAddedValueService::class => MotivationAndAddedValueService::class,
        IDocumentTypeService::class => DocumentTypeService::class,
        IUploadedDocumentsService::class => UploadedDocumentsService::class,
        IUnlockedFormService::class => UnlockedFormService::class
    ];
}
