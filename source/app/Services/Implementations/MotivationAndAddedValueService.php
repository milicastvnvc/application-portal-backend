<?php

namespace App\Services\Implementations;

use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IMotivationAndAddedValueRepository;
use App\Services\Interfaces\IMotivationAndAddedValueService;
use App\ViewModels\ActionResultResponse;
use App\ViewModels\FormResponse;
use Illuminate\Support\Facades\Validator;
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

    public function getByApplicationId($application_id, $user_id)
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $application_id,
            $user_id,
            relations: ['user', 'unlocked_forms']
        );

        $motivation = $this->motivationAndAddedValueRepository->findByApplicationId($application_id);

        $result = new FormResponse($motivation, $application);

        $response->setSuccess($result);

        return $response;
    }

    public function createOrUpdate($request)
    {
        $response = new ActionResultResponse();

        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $request->application_id,
            $request->user()->id,
            relations: ['application_progress', 'unlocked_forms'],
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
                    'mobility_impact' => $request->mobility_impact
                ]
            );

            if ($motivation_and_added_value === null) {
                $response->setErrors(['Error while changing motivation and added value form.']);
                throw new \Exception("Error while changing motivation and added value form.");
            }
            if (!$application->application_progress->motivation_and_added_value) {
                $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                    "motivation_and_added_value" => true
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

    public function validate($input_data)
    {
        $validator = Validator::make($input_data, [
            'application_id' =>  'required|numeric',
            'chosen_institution' => 'required|string|min:300|max:1000',
            'mobility_impact' => 'required|string|min:300|max:1000',
        ]);

        return $validator;
    }
}
