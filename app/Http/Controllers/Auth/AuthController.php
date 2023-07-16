<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            ...$request->validated(),
            'password' => Hash::make($request->password),
        ]);

        $user->notify(new VerifyEmailNotification());
        return response()->json($user);
    }



    public function login(LoginRequest $request): JsonResponse
    {
        $username = $request->username;
        $user = User::where(function ($query) use ($username) {
            $query->where('email', $username)
                  ->orWhere('username', $username);
        })->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => [trans('validation.valid-username')],
            ]);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => trans('validation.email'),
            ]);
        }

        auth()->login($user, $request->remember);
        session()->regenerate();
        return response()->json($user);

    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json();
    }
}
