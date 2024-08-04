<?php

namespace App\Services\Implementations;

use App\Enums\FormProgress;
use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IProposedHostUniversitiesRepository;
use App\Repositories\Interfaces\ISemesterRepository;
use App\Services\Interfaces\IProposedHostUniversitiesService;
use App\ViewModels\ActionResultResponse;
use App\ViewModels\ApplicationViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Support\Facades\DB;

class ProposedHostUniversitiesService implements IProposedHostUniversitiesService
{
    private $proposedHostUniversitiesRepository;
    private $applicationRepository;
    private $applicationProgressRepository;
    private $semesterRepository;

    public function __construct(
        IProposedHostUniversitiesRepository $proposedHostUniversitiesRepository,
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository,
        ISemesterRepository $semesterRepository
    ) {
        $this->proposedHostUniversitiesRepository = $proposedHostUniversitiesRepository;
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
        $this->semesterRepository = $semesterRepository;
    }

    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $application_id,
            $user,
            relations: ['user']
        );

        $host_universities = $this->proposedHostUniversitiesRepository->findByApplicationId($application_id);

        $semesters = $this->semesterRepository->getActiveSemesters();

        $result['form'] = $host_universities;
        $result['application'] = new ApplicationViewModel($application);
        $result['active_semesters'] = $semesters;
        $response->setSuccess($result);

        return $response;
    }

    public function createOrUpdate(Request $request): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $validator = $this->validate($request->all());

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
        if (!ApplicationHelper::checkCanYouModify($application, $forms['proposed-host-universities']))
        {
            $response->setErrors(['You cannot change this form, it\'s locked.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $host_universities = $this->proposedHostUniversitiesRepository->updateOrCreate(
                ['application_id' => $application->id],
                [
                    'application_id' => $request->application_id,
                    'host_institution' => $request->host_institution,
                    'department' => $request->department,
                    'host_institution_second' => $request->host_institution_second,
                    'department_second' => $request->department_second,
                    'semester_id' => $request->semester_id
                ]
            );

            if ($host_universities === null) {
                $response->setErrors(['Error while changing proposed host universities forms']);
                throw new \Exception("Error while changing proposed host universities forms");
            }
            if ($application->application_progress->proposed_host_universities == FormProgress::Incompleted) {
                $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                    "proposed_host_universities" => FormProgress::Completed
                ]);

                if (!$progress) {
                    $response->setErrors(['Error while changing proposed host universities forms']);
                    throw new \Exception("Error while changing proposed host universities forms");
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors))
                $response->setErrors([$e->getMessage()]);
            return $response;
        }

        $response->setSuccess($host_universities);
        return $response;
    }

    public function validate(mixed $input_data): Val
    {
        $validator = Validator::make($input_data, [
            'application_id' =>  'required|numeric',
            'host_institution' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'host_institution_second' => 'nullable|string|max:255',
            'department_second' => 'nullable|string|max:255',
            'semester_id' => 'exists:App\Models\Semester,id'
        ]);

        return $validator;
    }
}
