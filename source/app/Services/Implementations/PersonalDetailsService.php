<?php

namespace App\Services\Implementations;

use App\Enums\BinaryQuestion;
use App\Enums\FormProgress;
use App\Enums\Gender;
use App\Helpers\ApplicationHelper;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IPersonalDetailsRepository;
use App\Services\Interfaces\IPersonalDetailsService;
use App\ViewModels\ActionResultResponse;
use App\ViewModels\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Validation\Validator as Val;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\DB;

class PersonalDetailsService implements IPersonalDetailsService
{
    private $personalDetailsRepository;
    private $applicationRepository;
    private $applicationProgressRepository;

    public function __construct(
        IPersonalDetailsRepository $personalDetailsRepository,
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository
    ) {
        $this->personalDetailsRepository = $personalDetailsRepository;
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

        $details = $this->personalDetailsRepository->findByApplicationId($application_id);

        $result = new FormResponse($details, $application);

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
        if (!ApplicationHelper::checkCanYouModify($application, $forms['personal-details']))
        {
            $response->setErrors(['You cannot change this form, it\'s locked.']);
            return $response;
        }

        try {
            DB::beginTransaction();

            $personal_details = $this->personalDetailsRepository->updateOrCreate(
                ['application_id' => $application->id],
                [
                    'application_id' => $request->application_id,
                    'surname' => $request->surname,
                    'fornames' => $request->fornames,
                    'birth_date' => $request->birth_date,
                    'birth_place' => $request->birth_place,
                    'gender' => $request->gender,
                    'passport' => $request->passport,
                    'street' => $request->street,
                    'postcode' => $request->postcode,
                    'city' => $request->city,
                    'country' => $request->country,
                    'telephone' => $request->telephone,
                    'email' => $request->email,
                    'alternative_email' => $request->alternative_email,
                    'disadvantaged' => $request->disadvantaged,
                    'previous_host_institution' => $request->previous_host_institution,
                    'mobility_dates' => $request->mobility_dates,
                    'previous_participation' => $request->previous_participation,
                    'participation_count' => $request->participation_count
                ]
            );

            if ($personal_details === null) {
                $response->setErrors(['Error while changing personal details forms']);
                throw new \Exception("Error while changing personal details forms");
            }
            if ($application->application_progress->personal_details == FormProgress::Incompleted) {
                $progress = $this->applicationProgressRepository->update($application->application_progress->id, [
                    "personal_details" => FormProgress::Completed
                ]);

                if (!$progress) {
                    $response->setErrors(['Error while updating application progress']);
                    throw new \Exception("Error while changing personal details forms");
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (empty($response->errors))
                $response->setErrors([$e->getMessage()]);
            return $response;
        }

        $response->setSuccess($personal_details);
        return $response;
    }

    public function validate(mixed $input_data): Val
    {
        $validator = Validator::make($input_data, [
            'application_id' => 'required|numeric',
            'surname' => 'required|string|max:255',
            'fornames' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'gender' => [new Enum(Gender::class)],
            'passport' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postcode' => 'required|numeric',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'alternative_email' => 'nullable|string|email|max:255',
            'disadvantaged' => ['nullable', new Enum(BinaryQuestion::class)],
            'previous_host_institution' => 'nullable|string|max:255',
            'mobility_dates' => 'nullable|string',
            'previous_participation' => 'required|boolean',
            'participation_count' => 'nullable|integer|min:1|max:10',
        ]);

        return $validator;
    }
}
