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

    public function register($email, $password)
    {
        return $this->model->firstOrCreate([
            'email' => $email,
            'password' => $password
        ]);
    }

    public function addUserExternally($email, $providerId, $providerName)
    {
        return $this->model->updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'provider_id' => $providerId,
                'provider_name' => $providerName
            ]
        );
    }

    public function getUserByEmail($email)
    {
        return $this->model::whereEmail($email)->first();
    }

    public function getUserByProvider($providerId, $providerName)
    {
        return $this->model
            ->where('provider_id', $providerId)
            ->where('provider_name', $providerName)
            ->first();
    }

    public function updateUser($user)
    {
        $user->save();
    }

    public function getUserByVerificationCode($code, $reset_password = false)
    {
        if ($reset_password)
            return $this->model::where('reset_password_code', $code)->first();

        return $this->model::where('verification_code', $code)->first();
    }
}
