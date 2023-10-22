<?php

namespace App\Services\Implementations;

use App\Enums\Roles;
use App\ViewModels\ActionResultResponse;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IOtherMobilityRepository;
use App\Repositories\Interfaces\IUnlockedFormRepository;
use App\Services\Interfaces\IApplicationService;
use App\ViewModels\ApplicationViewModel;
use App\ViewModels\PaginationResultResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApplicationService implements IApplicationService
{
    private $applicationRepository;
    private $applicationProgressRepository;
    private $otherMobilityRepository;
    private $unlockFormsRepository;

    public function __construct(
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository,
        IOtherMobilityRepository $otherMobilityRepository,
        IUnlockedFormRepository $unlockFormsRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
        $this->otherMobilityRepository = $otherMobilityRepository;
        $this->unlockFormsRepository = $unlockFormsRepository;
    }

    public function getById($request)
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->findById(
            $request->id,
            relations: ['home_institution', 'mobility', 'application_progress', 'other_mobility', 'unlocked_forms']
        );

        if (!$application) {
            $response->setErrors(['Application with this id does not exist']);
            return $response;
        }

        if ($application->user_id != $request->user()->id && !$request->user()->hasRole(Roles::Admin)) {
            $response->setErrors(['Application with this id does not exist']);
            return $response;
        }

        $response->setSuccess(new ApplicationViewModel($application));

        return $response;
    }

    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $is_submitted = true)
    {
        $response = new ActionResultResponse();

        $pagination = $this->applicationRepository->getAllApplications($page, $search_key, $mobility_id, $home_institution_id, $per_page, $is_submitted);

        $data = new PaginationResultResponse($pagination);

        $response->setSuccess($data);

        return $response;
    }

    public function getMyApplications($user_id)
    {
        $applications = $this->applicationRepository->getApplicationsByUser($user_id);

        return $applications;
    }

    public function create($create_request)
    {
        $response = new ActionResultResponse();

        $validator = $this->validate($create_request->all());

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        if (!$create_request->mobility_id && !$create_request->other_mobility) {

            $response->setErrors(['You did not specify mobility.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $user_id = $create_request->user()->id;

            $application = $this->applicationRepository->create([
                "user_id" => $user_id,
                "mobility_id" => $create_request->mobility_id,
                "home_institution_id" => $create_request->home_institution_id
            ]);

            if ($application === null) {
                $response->setErrors(['Error while creating application']);
                throw new \Exception("Error while creating application");
            }

            if (!$create_request->mobility_id && $create_request->other_mobility) {
                $otherMobility = $this->otherMobilityRepository->create([
                    'application_id' => $application->id,
                    'description' => $create_request->other_mobility
                ]);
                if ($otherMobility === null) {
                    $response->setErrors(['Error while creating application']);
                    throw new \Exception("Error while creating application");
                }
            }

            $progress = $this->applicationProgressRepository->create([
                "application_id" => $application->id
            ]);

            if ($progress === null) {
                $response->setErrors(['Error while creating application']);
                throw new \Exception("Error while creating application");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors)) {
                $response->setErrors([$e->getMessage()]);
            }
            return $response;
        }

        $response->setSuccess($application);

        return $response;
    }

    public function submitApplication($request)
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $request->application_id,
            $request->user()->id,
            relations: ['application_progress', 'unlocked_forms']
        );

        $progress = $application->application_progress;
        if (
            !$progress->personal_details ||
            !$progress->home_institution ||
            !$progress->proposed_host_universities ||
            !$progress->motivation_and_added_value ||
            !$progress->documents_upload
        ) {
            $response->setErrors(['Not all forms are filled.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $isSuccessful = $this->applicationRepository->update(
                $application->id,
                [
                    'submitted_at' => Carbon::now()
                ]
            );

            if (!$isSuccessful) {
                $response->setErrors(['Error while submitting application']);
                throw new \Exception("Error while submitting application.");
            }

            $numOfUnlocked = count($application->unlocked_forms);

            $isDeleted = $application->unlocked_forms()->delete();

            if (!$isDeleted && $numOfUnlocked > 0)
            {
                $response->setErrors(['Error while submitting application']);
                throw new \Exception("Error while submitting application.");
            }


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors)) {
                $response->setErrors([$e->getMessage()]);
            }
            return $response;
        }

        $response->setSuccess($application);

        return $response;
    }

    public function validate($input_data)
    {

        $validator = Validator::make($input_data, [
            'mobility_id' => 'nullable|exists:App\Models\Mobility,id',
            'home_institution_id' => 'exists:App\Models\HomeInstitution,id',
            'other_mobility' => 'nullable|string'
        ]);

        return $validator;
    }
}
