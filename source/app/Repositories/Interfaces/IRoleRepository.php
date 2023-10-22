<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IRoleRepository extends IBaseRepository
{
    public function getRoleByName(string $name);

    public function addRolesForUser(User $user, array $roles);
}
