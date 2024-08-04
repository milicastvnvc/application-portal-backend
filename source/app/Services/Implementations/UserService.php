<?php

namespace App\Services\Implementations;

use App\Enums\Roles;
use App\ViewModels\ActionResultResponse;
use App\Mail\UserEmail;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;
use App\ViewModels\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserService implements IUserService
{

    private $userRepository;
    private $roleRepository;

    public function __construct(IUserRepository $userRepository, IRoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function register(Request $registerRequest): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $validator = Validator::make($registerRequest->all(), [
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $user = $this->userRepository->register($registerRequest->email,Hash::make($registerRequest->password));

        if ($user === null) {
            $response->setErrors(['Error while registering user']);
            return $response;
        }

        $role = $this->roleRepository->getRoleByName(Roles::Applicant->value);

        $user->roles()->attach($role->id);

        $verificationResponse = $this->sendVerifyCode($user->email);

        if (!$verificationResponse->success) {
            return $verificationResponse;
        }

        $response->setSuccess('You have successfully registered your account. Please check your email for verification link so you can countinue using application.');

        return $response;
    }

    public function login(Request $loginRequest): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $validator = Validator::make($loginRequest->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $credentials = $loginRequest->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            $response->setErrors(['Invalid credentials']);
            return $response;
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            $response->setErrors(['You have to verify email address to login to your account']);
            return $response;
        }

        $success['user'] =  new UserViewModel($user);
        $success['token'] =  $token;

        $response->setSuccess($success);

        return $response;
    }

    public function verify(Request $verifyRequest): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $user = $this->userRepository->getUserByVerificationCode($verifyRequest->code);

        if (!$user) {
            $response->setErrors(['Invalid verification link']);
            return $response;
        }

        if ($user->email_verified_at !== null) {
            $response->setSuccess('Your email is already verified.');
            return $response;
        }

        if ($user->verification_expiry_time < now()) {
            $response->setErrors(['Link for verifying email expired.'], $user->email);
            return $response;
        }

        $user->email_verified_at = now();
        $this->userRepository->updateUser($user);
        $response->setSuccess('Your email has been successfully verified.');

        return $response;
    }

    public function sendVerifyCode(string $email, bool $reset_password = false): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $user = $this->userRepository->getUserByEmail($email);

        if (!$user) {
            $response->setErrors(['User with this email does not exist.']);
            return $response;
        }

        if ($reset_password == true) {
            $code = uniqid();
            $link = config('constant.ResetPasswordLink') . $code;
            $subject = "Reset password";
            $view = config('constant.ResetPasswordHTMLTemplate');
            $text = config('constant.ResetPasswordTextTemplate');


            $user->reset_password_code = $code;
            $user->reset_password_expiry_time = now()->addMinutes(config('constant.VerificationLinkExpiryMinutes'));
            $this->userRepository->updateUser($user);
        } else {
            if ($user->email_verified_at !== null) {
                $response->setErrors(['User has already verified email.']);
                return $response;
            }

            $user->verification_code = uniqid();
            $user->verification_expiry_time = now()->addMinutes(config('constant.VerificationLinkExpiryMinutes'));
            $this->userRepository->updateUser($user);
            $link = config('constant.VerifyEmailLink') . $user->verification_code;
            $subject = "Verify email";
            $view = config('constant.VerifyEmailHTMLTemplate');
            $text = config('constant.VerifyEmailTextTemplate');
        }

        $mailInfo = (object) [
            'email' => $email,
            'subject' => $subject,
            'link' => $link,
            'view' => $view,
            'text' => $text
        ];

        Mail::to($email)->send(new UserEmail($mailInfo));

        $response->setSuccess(null);

        return $response;
    }

    public function resetPassword(Request $resetPasswordRequest): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $validator = Validator::make($resetPasswordRequest->all(), [
            'code' => 'required|string|min:13|max:13',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $response->setErrors($validator->errors()->all(), 'Validation Error.');
            return $response;
        }

        $user = $this->userRepository->getUserByVerificationCode($resetPasswordRequest->code, true);

        if (!$user) {
            $response->setErrors(['Invalid reset password link']);
            return $response;
        }

        if ($user->reset_password_expiry_time < now()) {
            $response->setErrors(['Link for reset password expired.']);
            return $response;
        }

        $user->password = Hash::make($resetPasswordRequest->password);
        $this->userRepository->updateUser($user);
        $response->setSuccess('You successfully updated your password. We will redirect you to login page in 3 seconds.');

        return $response;
    }
}
