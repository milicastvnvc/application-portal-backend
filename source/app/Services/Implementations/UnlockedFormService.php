<?php

namespace App\Services\Implementations;

use App\Repositories\Interfaces\IApplicationRepository;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\IUnlockedFormRepository;
use App\Services\Interfaces\IUnlockedFormService;
use App\ViewModels\ActionResultResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UnlockedFormService implements IUnlockedFormService
{
    private $unlockedFormRepository;
    private $applicationRepository;

    public function __construct(IUnlockedFormRepository $unlockedFormRepository, IApplicationRepository $applicationRepository)
    {
        $this->unlockedFormRepository = $unlockedFormRepository;
        $this->applicationRepository = $applicationRepository;
    }

    public function getUnlockedForm($application_id, $form_name)
    {
        $response = new ActionResultResponse();

        $unlocked_form = $this->unlockedFormRepository->findByApplicationIdAndFormName($application_id, $form_name);

        $response->setSuccess($unlocked_form);
        return $response;
    }

    public function toggleLock($request)
    {
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            $response = new ActionResultResponse();
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $application = $this->applicationRepository->findById($request->application_id, relations: ['unlocked_forms']);

        if (!$application) {
            $response = new ActionResultResponse();
            $response->setErrors(['Application doesn\'t exist']);
            return $response;
        }

        if ($request->should_unlock)
        {
            return $this->unlockForm($application, $request->form_name);
        }
        else
        {
            return $this->lockForm($application, $request->form_name);
        }
    }

    public function unlockForm($application, $form_name)
    {
        $response = new ActionResultResponse();

        $unlocked_form = $this->unlockedFormRepository->findByApplicationIdAndFormName($application->id, $form_name);

        if ($unlocked_form) {
            $response->setSuccess($unlocked_form);
            return $response;
        }

        try {
            DB::beginTransaction();

            if ($application->submitted_at != null) {
                $isSuccessful = $this->applicationRepository->update(
                    $application->id,
                    [
                        'submitted_at' => null
                    ]
                );

                if (!$isSuccessful) {
                    $response->setErrors(['Error while unlocking form.']);
                    throw new \Exception("Error while unlocking form.");
                }
            }

            $unlocked_form = $this->unlockedFormRepository->create(
                [
                    'application_id' => $application->id,
                    'form_name' => $form_name
                ]
            );

            if (!$unlocked_form) {
                $response->setErrors(['Error while unlocking form.']);
                throw new \Exception("Error while unlocking form.");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors)) {
                $response->setErrors([$e->getMessage()]);
            }
            return $response;
        }

        $response->setSuccess($unlocked_form);
        return $response;
    }

    public function lockForm($application, $form_name)
    {
        $response = new ActionResultResponse();

        $unlocked_form = $this->unlockedFormRepository->findByApplicationIdAndFormName($application->id, $form_name);

        if (!$unlocked_form)
        {
            $response->setErrors(['Form is already locked.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $isSuccessful = $this->unlockedFormRepository->deleteById($unlocked_form->id);
            if (!$isSuccessful) {
                $response->setErrors(['Error while locking form.']);
                throw new \Exception("Error while locking form.");
            }

            if (!$this->unlockedFormRepository->countByApplicationId($application->id)) {

                $isSuccessful = $this->applicationRepository->update($application->id, ['submitted_at' => Carbon::now()]);
                if (!$isSuccessful) {
                    $response->setErrors(['Error while locking form.']);
                    throw new \Exception("Error while locking form.");
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

        $response->setSuccess(null);
        return $response;
    }

    public function validate($input_data)
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
