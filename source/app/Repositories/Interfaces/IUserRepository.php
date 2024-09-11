<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository extends IBaseRepository
{
    public function register(string $email, string $password): ?User;

    public function getUserByEmail(string $email): ?User;

    public function getUserByVerificationCode(string $code, bool $reset_password = false): ?User;

    public function updateUser(mixed $user): void;

    public function getHomeInstitutionIdByUserId(int $userId): ?int;

}
