<?php

namespace App\Services\Implementations;

use App\Enums\ApplicationStatus;
use App\Enums\FormProgress;
use App\Models\ApplicationProgress;
use App\ViewModels\ActionResultResponse;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Services\Interfaces\IApplicationProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Validation\Rule;

class ApplicationProgressService implements IApplicationProgressService
{
    private $applicationProgressRepository;
    private $applicationRepository;

    public function __construct(IApplicationProgressRepository $applicationProgressRepository, IApplicationRepository $applicationRepository)
    {
        $this->applicationProgressRepository = $applicationProgressRepository;
        $this->applicationRepository = $applicationRepository;
    }

    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser($application_id, $user);

        $progress = $this->applicationProgressRepository->findByApplicationId($application_id);

        if(!$progress) {
            $response->setErrors(['Application progress with this id does not exist']);
            return $response;
        }

        $response->setSuccess($progress);

        return $response;

    }

    public function toggleLock(Request $request): ActionResultResponse
    {
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            $response = new ActionResultResponse();
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $application = $this->applicationRepository->findById($request->application_id, relations: ['application_progress']);

        if (!$application) {
            $response = new ActionResultResponse();
            $response->setErrors(['Application doesn\'t exist']);
            return $response;
        }

        if ($application->status == ApplicationStatus::Created)
        {
            $response = new ActionResultResponse();
            $response->setErrors(['Application is not submitted.']);
            return $response;
        }

        if ($request->should_unlock)
        {
            return $this->unlockForm($application->application_progress, $request->form_name);
        }
        else
        {
            return $this->lockForm($application->application_progress, $request->form_name);
        }
    }

    public function unlockForm(ApplicationProgress $progress, string $form_name): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $formStatus = $progress[$form_name];

        if ($formStatus == FormProgress::Unlocked) {
            $response->setSuccess(null);
            return $response;
        }

        $success = $this->applicationProgressRepository->update($progress['id'],
            [
                $form_name => FormProgress::Unlocked
            ]
        );

        if (!$success) {
            $response->setErrors(['Error while unlocking form.']);
            throw new \Exception("Error while unlocking form.");
        }

        $response->setSuccess($formStatus);
        return $response;
    }

    public function lockForm(ApplicationProgress $progress, string $form_name): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $formStatus = $progress[$form_name];

        if ($formStatus == FormProgress::Completed)
        {
            $response->setErrors(['Form is already locked.']);
            return $response;
        }

        $success = $this->applicationProgressRepository->update($progress['id'],
            [
                $form_name => FormProgress::Completed
            ]
        );

        if (!$success) {
            $response->setErrors(['Error while locking form.']);
            throw new \Exception("Error while locking form.");
        }

        $response->setSuccess($formStatus);
        return $response;
    }

    public function validate(mixed $input_data): Val
    {

        $validator = Validator::make($input_data, [

            'application_id' =>  'required|numeric',
            'form_name' => [
                'required',
                Rule::in(config('constant.FormsInfo'))
            ],
            'should_unlock' => 'required|boolean'
        ]);

        return $validator;
    }
}
