<?php

namespace App\Repositories\Implementations;

use App\Enums\ApplicationStatus;
use App\Enums\Roles;
use App\Models\Application;
use App\Repositories\Interfaces\IApplicationRepository;
use Illuminate\Database\Eloquent\Collection;

class ApplicationRepository extends BaseRepository implements IApplicationRepository
{
    protected $model;

    public function __construct(Application $model)
    {
        $this->model = $model;
    }

    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $status = null, $call_id = null): mixed
    {
        $query = $this->model;

        if (!empty($search_key)) {
            $query = $query->whereHas('user', function ($query) use ($search_key) {
                return $query->where('email', 'LIKE', '%' . $search_key . '%');
            });
        }

        if ($mobility_id) {
            $query = $query->whereHas('mobility', function ($query) use ($mobility_id) {
                return $query->where('id', '=', $mobility_id);
            });
        }

        if ($home_institution_id) {
            $query = $query->whereHas('home_institution', function ($query) use ($home_institution_id) {
                return $query->where('id', '=', $home_institution_id);
            });
        }

        if ($status && ApplicationStatus::from($status) != ApplicationStatus::Created) {
            $query = $query->where('status', '=', $status);
        }
        else {
            $query = $query->where('status', '!=', ApplicationStatus::Created);
        }

        if ($call_id) {
            $query = $query->where('call_id', '=', $call_id);
        }

        return $query
            ->with(['user:id,email',
            'home_institution:id,name',
            'mobility:id,name',
            'other_mobility'  => function ($query) {
                $query->select('application_id', 'id', 'description');
            },
            'personal_details' => function ($query) {
                $query->select('application_id', 'surname', 'fornames');
            }])
            ->orderBy('submitted_at', 'desc')
            ->paginate($per_page, ['*'], 'page', $page);
    }

    public function getApplicationsByUser($user_id): Collection
    {
        return $this->model
            ::with(['home_institution', 'mobility:id,name,description', 'other_mobility'])
            ->where('user_id', $user_id)
            ->where('status', '!=', ApplicationStatus::Rejected)
            ->get(['id', 'user_id', 'mobility_id', 'home_institution_id', 'status', 'submitted_at', 'created_at']);
    }

    public function getApplicationByIdAndUser($id, $user, array $relations = [], $adminAccess = true): Application
    {
        if (($adminAccess && $user->hasRole(Roles::Admin))||$user->hasRole(Roles::Coordinator)) {
            return $this->model
                ->where('id', $id)
                ->with($relations)
                ->firstOrFail();
        }

        return $this->model
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->with($relations)
            ->firstOrFail();
    }

    public function deleteApplication($applicationId)
    {
        $application = Application::find($applicationId);

        if (!$application) {
            return false;
        }

        return $application->delete();
    }
}
