<?php

namespace App\Repositories\Implementations;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(string $email, string $password): ?User
    {
        return $this->model->firstOrCreate([
            'email' => $email,
            'password' => $password
        ]);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->model::whereEmail($email)->first();
    }

    public function updateUser(mixed $user): void
    {
        $user->save();
    }

    public function getUserByVerificationCode(string $code, bool $reset_password = false): ?User
    {
        if ($reset_password)
            return $this->model::where('reset_password_code', $code)->first();

        return $this->model::where('verification_code', $code)->first();
    }
}
