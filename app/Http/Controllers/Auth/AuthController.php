<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            ...$request->validated(),
            'password' => Hash::make($request->password),
        ]);

        $user->notify(new VerifyEmailNotification());
    }



    public function login(LoginRequest $request)
    {
        $username = $request->username;
        $user = User::where(function ($query) use ($username) {
            $query->where('email', $username)
                  ->orWhere('username', $username);
        })->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => 'The username must be a valid email address or username',
            ]);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'The provided credentials are incorrect',
            ]);
        }

        auth()->login($user, $request->remember);
        session()->regenerate();
        return response()->json(['user' => $user]);

    }
}
