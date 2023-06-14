<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetEmailVeifyRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function notify(PasswordResetEmailVeifyRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => trans('error')]);
        }
        $token = app('auth.password.broker')->createToken($user);
        $verificationUrl = 'http://localhost:5173/?token=' . $token . '&email=' . urlencode($request->email);
        $user->notify(new PasswordResetNotification($verificationUrl));

    }
    public function update(PasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }

}
