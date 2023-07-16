<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Notifications\VerifyNewEmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if (empty($data['username'])) {
            unset($data['username']);
        }

        if (empty($data['email'])) {
            unset($data['email']);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images');
        }
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $newEmail = $data['email'];
            unset($data['email']);
        }

        $message = 'UserInfo updated successfully';

        if (!empty($newEmail)) {
            $user->notify(new VerifyNewEmailNotification($newEmail));
            $message = 'Please check your email to verify the new email address.';
        }
        $user->update($data);
        $user->save();

        return response()->json(['message' => $message]);
    }


    public function verify($id, $hash): JsonResponse
    {
        $user = request()->user();
        $newEmail = request()->query('new_email');

        if ($user && sha1($newEmail) === $hash) {
            $user->email = $newEmail;
            $user->markEmailAsVerified();
            $user->save();
            event(new Verified($user));
            return response()->json('email verified');
        }

        return response()->json('verification failed', 400);
    }

}
