<?php

namespace App\Repositories\Implementations;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\IRoleRepository;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getRoleByName(string $name)
    {
        return $this->model
        ->where('name', $name)
        ->first();
    }

    public function addRolesForUser(User $user, array $roles)
    {
        return $user->roles()->attach($roles);
    }
}
