<?php
namespace App\Services\Constructors;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;

interface AuthConstructor
{
    public function register(RegisterRequest $request);

    public function login(LoginRequest $request);

    public function current();

    public function forgotPassword(ForgotPasswordRequest $request);

    public function showResetForm(ForgotPasswordRequest $request, $token);

    public function resetPassword(ResetPasswordRequest $request);

    public function logout();
}