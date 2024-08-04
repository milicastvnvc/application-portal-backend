<?php

namespace App\Services\Implementations;

use App\Enums\FormProgress;
use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IHomeInstitutionFormRepository;
use App\Services\Interfaces\IHomeInstitutionFormService;
use App\ViewModels\ActionResultResponse;
use App\ViewModels\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Support\Facades\DB;

class HomeInstitutionFormService implements IHomeInstitutionFormService
{
    private $homeInstitutionFormRepository;
    private $applicationRepository;
    private $applicationProgressRepository;

    public function __construct(
        IHomeInstitutionFormRepository $homeInstitutionFormRepository,
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository
    ) {
        $this->homeInstitutionFormRepository = $homeInstitutionFormRepository;
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
    }

    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $application_id,
            $user,
            relations: ['home_institution', 'user']);

        $home_institution = $this->homeInstitutionFormRepository->findByApplicationId($application_id);

        $result = new FormResponse($home_institution , $application);

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

        if (!ApplicationHelper::checkCanYouModify($application, $forms['home-institution']))
        {
            $response->setErrors(['You cannot change this form, it\'s locked.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $home_institution = $this->homeInstitutionFormRepository->updateOrCreate(
                ['application_id' => $application->id],
                [
                    'application_id' => $request->application_id,
                    'faculty' => $request->faculty,
                    'department' => $request->department,
                    'current_grade' => $request->current_grade,
                    'previous_gpa' => $request->previous_gpa,
                    'study_program' => $request->study_program,
                    'responsible_person' => $request->responsible_person,
                    'email_responsible_person' => $request->email_responsible_person,
                    'other_contact' => $request->other_contact
                ]
            );

            if ($home_institution === null) {
                $response->setErrors(['Error while changing home institution form.']);
                throw new \Exception("Error while changing home institution form.");
            }
            if ($application->application_progress->home_institution == FormProgress::Incompleted) {
                $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                    "home_institution" => FormProgress::Completed
                ]);

                if (!$progress) {
                    $response->setErrors(['Error while changing home institution form.']);
                    throw new \Exception("Error while changing home institution form.");
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors)) {
                $response->setErrors([$e->getMessage()]);
            }
            return $response;
        }

        $response->setSuccess($home_institution);
        return $response;
    }

    public function validate(mixed $input_data): Val
    {
        $validator = Validator::make($input_data, [
            'application_id' =>  'required|numeric',
            'faculty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'current_grade' => 'nullable|numeric|min:6|max:10',
            'previous_gpa' => 'nullable|numeric|min:6|max:10',
            'study_program' => 'required|string|max:255',
            'responsible_person' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'email_responsible_person' => 'required|string|email',
            'other_contact' => 'nullable|string|max:255'
        ]);

        return $validator;
    }
}
