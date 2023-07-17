<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    public function verify(User $id): JsonResponse
    {


        if ($id->markEmailAsVerified()) {
            event(new Verified($id));

            return response()->json('email verified successfuly');
        }

    }

}
