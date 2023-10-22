<?php

namespace App\Repositories\Interfaces;

interface IUserRepository extends IBaseRepository
{
    public function register($email, $password);

    public function addUserExternally($email, $providerId, $providerName);

    public function getUserByEmail($email);

    public function getUserByProvider($providerId, $providerName);

    public function getUserByVerificationCode($code, $reset_password = false);

    public function updateUser($user);
}
