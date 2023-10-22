<?php

namespace App\Providers;

use App\Repositories\Implementations\ApplicationProgressRepository;
use App\Repositories\Implementations\ApplicationRepository;
use App\Repositories\Implementations\BaseRepository;
use App\Repositories\Implementations\DocumentTypeRepository;
use App\Repositories\Implementations\FormRepository;
use App\Repositories\Implementations\HomeInstitutionFormRepository;
use App\Repositories\Implementations\HomeInstitutionRepository;
use App\Repositories\Implementations\MobilityRepository;
use App\Repositories\Implementations\MotivationAndAddedValueRepository;
use App\Repositories\Implementations\OtherMobilityRepository;
use App\Repositories\Implementations\PersonalDetailsRepository;
use App\Repositories\Implementations\ProposedHostUniversitiesRepository;
use App\Repositories\Implementations\RoleRepository;
use App\Repositories\Implementations\SemesterRepository;
use App\Repositories\Implementations\UnlockedFormRepository;
use App\Repositories\Implementations\UploadedDocumentsRepository;
use App\Repositories\Implementations\UserRepository;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IDocumentTypeRepository;
use App\Repositories\Interfaces\IFormRepository;
use App\Repositories\Interfaces\IHomeInstitutionFormRepository;
use App\Repositories\Interfaces\IHomeInstitutionRepository;
use App\Repositories\Interfaces\IMobilityRepository;
use App\Repositories\Interfaces\IMotivationAndAddedValueRepository;
use App\Repositories\Interfaces\IOtherMobilityRepository;
use App\Repositories\Interfaces\IPersonalDetailsRepository;
use App\Repositories\Interfaces\IProposedHostUniversitiesRepository;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\ISemesterRepository;
use App\Repositories\Interfaces\IUnlockedFormRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IUploadedDocumentsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IBaseRepository::class => BaseRepository::class,
        IFormRepository::class => FormRepository::class,
        IUserRepository::class => UserRepository::class,
        IRoleRepository::class => RoleRepository::class,
        IApplicationRepository::class => ApplicationRepository::class,
        IHomeInstitutionRepository::class => HomeInstitutionRepository::class,
        IApplicationProgressRepository::class => ApplicationProgressRepository::class,
        IMobilityRepository::class => MobilityRepository::class,
        IOtherMobilityRepository::class => OtherMobilityRepository::class,
        IPersonalDetailsRepository::class => PersonalDetailsRepository::class,
        IHomeInstitutionFormRepository::class => HomeInstitutionFormRepository::class,
        IProposedHostUniversitiesRepository::class => ProposedHostUniversitiesRepository::class,
        ISemesterRepository::class => SemesterRepository::class,
        IMotivationAndAddedValueRepository::class => MotivationAndAddedValueRepository::class,
        IDocumentTypeRepository::class => DocumentTypeRepository::class,
        IUploadedDocumentsRepository::class => UploadedDocumentsRepository::class,
        IUnlockedFormRepository::class => UnlockedFormRepository::class
    ];
}
