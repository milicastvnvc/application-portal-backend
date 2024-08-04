<?php

namespace App\Services\Implementations;

use App\Enums\FormProgress;
use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IMotivationAndAddedValueRepository;
use App\Services\Interfaces\IMotivationAndAddedValueService;
use App\ViewModels\ActionResultResponse;
use App\ViewModels\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Support\Facades\DB;


class MotivationAndAddedValueService implements IMotivationAndAddedValueService
{
    private $motivationAndAddedValueRepository;
    private $applicationRepository;
    private $applicationProgressRepository;

    public function __construct(
        IMotivationAndAddedValueRepository $motivationAndAddedValueRepository,
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository
    ) {
        $this->motivationAndAddedValueRepository = $motivationAndAddedValueRepository;
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
    }

    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $application_id,
            $user,
            relations: ['user']
        );

        $motivation = $this->motivationAndAddedValueRepository->findByApplicationId($application_id);

        $result = new FormResponse($motivation, $application);

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
        if (!ApplicationHelper::checkCanYouModify($application, $forms['motivation-and-added-value']))
        {
            $response->setErrors(['You cannot change this form, it\'s locked.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $motivation_and_added_value = $this->motivationAndAddedValueRepository->updateOrCreate(
                ['application_id' => $application->id],
                [
                    'application_id' => $request->application_id,
                    'chosen_institution' => $request->chosen_institution,
                    'mobility_impact' => $request->mobility_impact,
                    'chosen_institution_second' => $request->chosen_institution_second
                ]
            );

            if ($motivation_and_added_value === null) {
                $response->setErrors(['Error while changing motivation and added value form.']);
                throw new \Exception("Error while changing motivation and added value form.");
            }
            if ($application->application_progress->motivation_and_added_value == FormProgress::Incompleted) {
                $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                    "motivation_and_added_value" => FormProgress::Completed
                ]);

                if (!$progress) {
                    $response->setErrors(['Error while changing motivation and added value form.']);
                    throw new \Exception("Error while changing motivation and added value form.");
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

        $response->setSuccess($motivation_and_added_value);

        return $response;
    }

    public function validate(mixed $input_data): Val
    {
        $validator = Validator::make($input_data, [
            'application_id' =>  'required|numeric',
            'chosen_institution' => 'required|string|min:300|max:1500',
            'chosen_institution_second' => 'nullable|string|min:300|max:1500',
            'mobility_impact' => 'required|string|min:300|max:2000'
        ]);

        return $validator;
    }
}
