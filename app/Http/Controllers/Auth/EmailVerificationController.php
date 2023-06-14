<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(User $id)
    {

        if ($id->markEmailAsVerified()) {
            event(new Verified($id));
            return redirect('http://localhost:5173/?confirmed=true');
        }

    }

}
