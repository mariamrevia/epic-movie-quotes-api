<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function handleRedirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(): RedirectResponse
    {

        $googleUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            [
            'google_id' => $googleUser->id,
            'username' => $googleUser->name,
            'email' => $googleUser->email

         ]
        );

        Auth::login($user);
        return redirect('http://localhost:5173/newsFeed?confirmed=true');
    }

}
