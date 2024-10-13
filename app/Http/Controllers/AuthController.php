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
    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        return AuthFacade::register($request);
    }

    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        return AuthFacade::login($request);
    }

    /**
     * Get current user
     *
     * @return void
     */
    public function current()
    {
        return AuthFacade::current();
    }

    /**
     * Forgot password
     *
     * @param ForgotPasswordRequest $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return AuthFacade::forgotPassword($request);
    }

    /**
     * Show reset form
     *
     * @param ForgotPasswordRequest $request
     * @param [type] $token
     * @return void
     */
    public function showResetForm(ForgotPasswordRequest $request, $token)
    {
        $token = AuthFacade::showResetForm($request , $token);
        return view('auth.passwords.reset', $token);
    }

    /**
     * Reset password
     *
     * @param ResetPasswordRequest $request
     * @return void
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        return AuthFacade::resetPassword($request);
    }

    /**
     * Logout a user
     *
     * @return void
     */
    public function logout()
    {
        AuthFacade::logout();
    }
}
