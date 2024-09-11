<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;

interface IUserService
{
    public function register(Request $registerRequest): ActionResultResponse;

    public function login(Request $loginRequest): ActionResultResponse;

    public function verify(Request $verifyRequest): ActionResultResponse;

    public function sendVerifyCode(string $email, bool $reset_password = false): ActionResultResponse;

    public function resetPassword(Request $resetPasswordRequest): ActionResultResponse;

    public function getHomeInstitutionId(int $userId): ?int;
}
