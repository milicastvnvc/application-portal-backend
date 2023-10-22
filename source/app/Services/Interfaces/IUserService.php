<?php

namespace App\Services\Interfaces;

interface IUserService
{

    public function register($registerRequest);

    public function login($loginRequest);

    public function googleLogin($loginRequest);

    public function verify($verifyRequest);

    public function sendVerifyCode($email, $reset_password = false);

    public function resetPassword($resetPasswordRequest);
}
