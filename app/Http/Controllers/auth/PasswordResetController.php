<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetEmailVeifyRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function notify(PasswordResetEmailVeifyRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => trans('error')]);
        }
        $token = app('auth.password.broker')->createToken($user);
        $verificationUrl = config('app.frontend_url') . '/?token=' . $token . '&email=' . urlencode($request->email);
        $user->notify(new PasswordResetNotification($verificationUrl));
        return response()->json(['message' => 'Notification sent']);

    }
    public function update(PasswordResetRequest $request): JsonResponse
    {
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful']);
        } else {
            return response()->json(['message' => 'Password reset failed'], 400);
        }
    }

}
