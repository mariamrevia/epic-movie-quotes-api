<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(User $id): RedirectResponse
    {

        if ($id->markEmailAsVerified()) {
            event(new Verified($id));
            $redirectUrl = config('app.frontend_url') . '/?confirmed=true';
            return redirect($redirectUrl);
        }

    }

}