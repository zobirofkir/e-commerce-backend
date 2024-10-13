<?php

namespace App\Services\Services;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Services\Constructors\AuthConstructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService implements AuthConstructor
{
    /**
     * Register: Create a new user
     *
     * @param RegisterRequest $request
     * @return RegisterResource
     */
    public function register(RegisterRequest $request) : RegisterResource
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $user = User::create($validated);
        return RegisterResource::make($user);
    }

    /**
     * Login: Authenticate a user
     *
     * @param LoginRequest $request
     * @return LoginResource
     */
    public function login(LoginRequest $request) : LoginResource
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return abort(401);
        }

        return LoginResource::make($user);
    }

    /**
     * Get current user
     *
     * @return RegisterResource
     */
    public function current() : RegisterResource
    {
        return RegisterResource::make(
            User::find(Auth::user()->id)
        );
    }

    /**
     * Forgot password
     *
     * @param ForgotPasswordRequest $request
     * @return bool
     */
    public function forgotPassword(ForgotPasswordRequest $request) : bool 
    {
        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return true;
        }

        return abort(500); 
    }

    /**
     * Show reset form
     *
     * @param [type] $token
     * @return array
     */
    public function showResetForm(ForgotPasswordRequest $request, $token) : array
    {
        return [
            'token' => $token,
            'email' => $request->email,
        ];
    }

    /**
     * Reset password
     *
     * @param ResetPasswordRequest $request
     * @return void
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    
        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['status' => 'success', 'message' => __('Your password has been updated successfully.')]);
        }
    
        return response()->json(['status' => 'error', 'message' => __($status)], 400);
    }
        
    /**
     * Logout
     *
     * @return bool
     */
    public function logout() : bool
    {
        Auth::user()->token()->revoke();
        return true;
    }
}