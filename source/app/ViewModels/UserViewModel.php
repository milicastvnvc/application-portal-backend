<?php

namespace App\ViewModels;

use App\Models\User;

class UserViewModel
{
    public $id;
    public $email;
    public $email_verified_at;
    public $roles = [];

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->email = $user->email;
        $this->email_verified_at = $user->email_verified_at;
        foreach ($user->roles as $role) {
            $this->roles[] = $role->name;
        }

    }
}
