<?php

namespace App\Services\Implementations;

use App\Enums\ApplicationStatus;
use App\Enums\FormProgress;
use App\Enums\Roles;
use App\ViewModels\ActionResultResponse;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Repositories\Interfaces\IOtherMobilityRepository;
use App\Services\Interfaces\IApplicationService;
use App\ViewModels\ApplicationViewModel;
use App\ViewModels\PaginationResultResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Val;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;

class ApplicationService implements IApplicationService
{
    private $applicationRepository;
    private $applicationProgressRepository;
    private $otherMobilityRepository;

    public function __construct(
        IApplicationRepository $applicationRepository,
        IApplicationProgressRepository $applicationProgressRepository,
        IOtherMobilityRepository $otherMobilityRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->applicationProgressRepository = $applicationProgressRepository;
        $this->otherMobilityRepository = $otherMobilityRepository;
    }

    public function getById(Request $request): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->findById(
            $request->id,
            relations: ['home_institution', 'mobility', 'application_progress', 'other_mobility']
        );

        if (!$application) {
            $response->setErrors(['Application with this id does not exist']);
            return $response;
        }

        if ($application->user_id != $request->user()->id && !$request->user()->hasRole(Roles::Admin) && !$request->user()->hasRole(Roles::Coordinator)) {
            $response->setErrors(['Application with this id does not exist']);
            return $response;
        }

        $response->setSuccess(new ApplicationViewModel($application));

        return $response;
    }

    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $status = null, $contest_id = null): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $pagination = $this->applicationRepository->getAllApplications($page, $search_key, $mobility_id, $home_institution_id, $per_page, $status, $contest_id);

        $data = new PaginationResultResponse($pagination);

        $response->setSuccess($data);

        return $response;
    }

    public function getMyApplications(int $user_id): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $applications = $this->applicationRepository->getApplicationsByUser($user_id);

        $response->setSuccess($applications);

        return $response;
    }

    public function create(Request $create_request): ActionResultResponse
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
                "home_institution_id" => $create_request->home_institution_id,
                "status" => ApplicationStatus::Created
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

    public function submitApplication(Request $request): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $application = $this->applicationRepository->getApplicationByIdAndUser(
            $request->application_id,
            $request->user(),
            relations: ['application_progress'],
            adminAccess: false
        );

        $forms = config('constant.FormsInfo');
        $progress = $application->application_progress;
        foreach ($forms as $key => $form) {
            if ($progress[$form] == FormProgress::Incompleted) {
                $response->setErrors(['Not all forms are filled.']);
                return $response;
            }
        }

        try {
            DB::beginTransaction();

            $isSuccessful = $this->applicationRepository->update(
                $application->id,
                [
                    'submitted_at' => Carbon::now(),
                    'status' => ApplicationStatus::Pending
                ]
            );

            if (!$isSuccessful) {
                $response->setErrors(['Error while submitting application']);
                throw new \Exception("Error while submitting application.");
            }
            $updatedForms = [];
            foreach ($forms as $form) {
                if ($progress[$form] == FormProgress::Unlocked) {
                    $updatedForms[$form] = FormProgress::Completed;
                }
            }
            if (!empty($updatedForms)) {
                $success = $this->applicationProgressRepository->update($progress['id'], $updatedForms);

                if (!$success) {
                    $response->setErrors(['Error while submitting application']);
                    throw new \Exception("Error while submitting application.");
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

        $email = $request->user()->email;
        $subject = "Confirmation of Submission";
        $view = config('constant.PendingApplicationHTMLTemplate');
        $text = config('constant.PendingApplicationTextTemplate');

        $mailInfo = (object) [
            'email' => $email,
            'subject' => $subject,
            'link' => "",
            'view' => $view,
            'text' => $text
        ];

        Mail::to($email)->send(new UserEmail($mailInfo));

        $response->setSuccess($application);

        return $response;
    }

    public function changeApplicationStatus(Request $request): ActionResultResponse
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
            relations: ['application_progress']
        );

        $progress = $application->application_progress;

        $status = ApplicationStatus::from($request->status);
        $errorText = "";
        $link = "";
        $forms = config('constant.FormsInfo');

        foreach ($forms as $form) {
            if ($progress[$form] == FormProgress::Incompleted) {
                $response->setErrors(["Not all forms are filled. You cannot change status of application at this point."]);
                return $response;
            }
        }

        switch ($status) {
            case ApplicationStatus::Completed:
                $updatedForms = [];

                foreach ($forms as $form) {
                    if ($progress[$form] == FormProgress::Unlocked) {
                        $updatedForms[$form] = FormProgress::Completed;
                    }
                }
                if (!empty($updatedForms)) {
                    $success = $this->applicationProgressRepository->update($progress['id'], $updatedForms);

                    if (!$success) {
                        $response->setErrors(['Error while completing application']);
                        throw new \Exception("Error while completing application.");
                    }
                }
                $errorText = "Error while approving application";
                $view = config('constant.CompletedApplicationHTMLTemplate');
                $text = config('constant.CompletedApplicationTextTemplate');
                $subject = "Confirmation of Completed Application";
                break;
            case ApplicationStatus::Rejected:
                $errorText = "Error while rejecting application";
                $view = config('constant.RejectedApplicationHTMLTemplate');
                $text = config('constant.RejectedApplicationTextTemplate');
                $subject = "Notification About Application Status";
                break;
            case ApplicationStatus::AdditionalDocuments:
                $counted = 0;
                foreach ($forms as $key => $form) {
                    if ($progress[$form] == FormProgress::Unlocked) {
                        $counted += 1;
                    }
                }
                if (!$counted) {
                    $response->setErrors(["You haven't unlocked any form."]);
                    return $response;
                }

                $errorText = "Error while changing status of application";
                $view = config('constant.DocumentsRequiredApplicationHTMLTemplate');
                $text = config('constant.DocumentsRequiredApplicationTextTemplate');
                $subject = "Additional Documents Required for Your Application";
                $link = config('constant.ApplicationLink') . $application->id;
                break;
            default:
                $response->setErrors(["The application status cannot be changed."]);
                return $response;
                break;
        }

        $isSuccessful = $this->applicationRepository->update(
            $application->id,
            [
                'status' => $status
            ]
        );

        if (!$isSuccessful) {
            $response->setErrors([$errorText]);
            return $response;
        }

        $email = $application->user->email;
        $mailInfo = (object) [
            'email' => $email,
            'subject' => $subject,
            'link' => $link,
            'view' => $view,
            'text' => $text
        ];

        Mail::to($email)->send(new UserEmail($mailInfo));

        $response->setSuccess(null);

        return $response;
    }

    public function validate(mixed $input_data, $create = true): Val
    {
        if ($create) {
            $validator = Validator::make($input_data, [
                'mobility_id' => 'nullable|exists:App\Models\Mobility,id',
                'home_institution_id' => 'exists:App\Models\HomeInstitution,id',
                'other_mobility' => 'nullable|string'
            ]);
        } else {
            $validator = Validator::make($input_data, [
                'application_id' => 'required|numeric',
                'status' => [new Enum(ApplicationStatus::class)]
            ]);
        }


        return $validator;
    }


    public function deleteApplication($applicationId)
    {
        // \Log::info('Deleting application with ID: ' . $applicationId);

        DB::beginTransaction();

        try {
            $application = $this->applicationRepository->findById($applicationId);
            if (!$application) {
                // \Log::error('Application not found with ID: ' . $applicationId);
                return [
                    'success' => false,
                    'message' => 'Application not found'
                ];
            }

            $application->delete();
            DB::commit();

            return [
                'success' => true,
                'message' => 'Application deleted successfully'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Error while deleting application: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Error while deleting application'
            ];
        }
    }



}
