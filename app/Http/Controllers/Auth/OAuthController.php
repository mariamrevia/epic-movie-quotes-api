<?php

namespace App\Http\Controllers\auth;

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
            ['email' => $googleUser->email],
            [
                'google_id' => $googleUser->id,
                'username' => $googleUser->name,
                'image' => $googleUser->getAvatar(),
            ]
        );

        Auth::login($user);
        $redirectUrl = config('app.frontend_url') . '/newsFeed?confirmed=true';
        return redirect($redirectUrl);
    }

}
