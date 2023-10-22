<?php

namespace App\Repositories\Implementations;

use App\Models\Application;
use App\Repositories\Interfaces\IApplicationRepository;

class ApplicationRepository extends BaseRepository implements IApplicationRepository
{
    protected $model;

    public function __construct(Application $model)
    {
        $this->model = $model;
    }

    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $is_submitted = true)
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

        if ($is_submitted) {
            $query = $query->whereNotNull('submitted_at');
        }
        else { //get unlocked

            $query = $query
                ->whereNull('submitted_at')
                ->whereExists(function ($query) {
                    $query->select("unlocked_forms.*")
                        ->from('unlocked_forms')
                        ->whereRaw('unlocked_forms.application_id = applications.id');
                });
        }

        return $query
            ->with(['user', 'home_institution', 'mobility', 'other_mobility'])
            ->paginate($per_page, ['*'], 'page', $page);
    }

    public function getApplicationsByUser($user_id)
    {
        return $this->model
            ::with(['home_institution', 'mobility:id,name,description', 'other_mobility'])
            ->where('user_id', $user_id)
            ->get(['id', 'user_id', 'mobility_id', 'submitted_at', 'home_institution_id', 'created_at']);
    }

    public function getApplicationByIdAndUser($id, $user_id, array $relations = [], $adminAccess = true)
    {
        if ($adminAccess) {
            return $this->model
                ->where('id', $id)
                ->with($relations)
                ->firstOrFail();
        }

        return $this->model
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->with($relations)
            ->firstOrFail();
    }
}
