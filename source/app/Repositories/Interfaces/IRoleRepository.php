<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;
use App\Models\User;

interface IRoleRepository extends IBaseRepository
{
    public function getRoleByName(string $name): ?Role;

    public function addRolesForUser(User $user, array $roles): void;
}
