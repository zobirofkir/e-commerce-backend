<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest; 
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Services\Facades\AuthFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        return AuthFacade::register($request);
    }

    public function login(LoginRequest $request)
    {
        return AuthFacade::login($request);
    }

    public function current()
    {
        return AuthFacade::current();
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return AuthFacade::forgotPassword($request);
    }

    public function showResetForm(ForgotPasswordRequest $request, $token)
    {
        $token = AuthFacade::showResetForm($request , $token);
        return view('auth.passwords.reset', $token);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return AuthFacade::resetPassword($request);
    }

    public function logout()
    {
        AuthFacade::logout();
    }
}
