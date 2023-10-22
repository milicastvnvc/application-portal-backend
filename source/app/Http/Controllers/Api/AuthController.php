<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\IUserService;

class AuthController extends Controller
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $response = $this->userService->register($request);

        return response()->ok($response);
    }

    public function login(Request $request)
    {
        $response = $this->userService->login($request);

        return response()->ok($response);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $response = $this->userService->verify($request);

        return response()->ok($response);
    }

    public function sendVerifyCode(Request $request)
    {
        $response = $this->userService->sendVerifyCode($request->email, $request->resetPassword);

        return response()->ok($response);
    }

    public function resetPassword(Request $request)
    {
        $response = $this->userService->resetPassword($request);

        return response()->ok($response);
    }

    public function googleLogin(Request $request)
    {
        $response = $this->userService->googleLogin($request);

        return response()->ok($response);
    }
}
