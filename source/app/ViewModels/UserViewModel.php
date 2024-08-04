<?php

namespace App\ViewModels;

use App\Models\User;

class UserViewModel
{
    public $id;
    public $email;
    public $roles = [];

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->email = $user->email;
        foreach ($user->roles as $role) {
            $this->roles[] = $role->name;
        }
    }
}
