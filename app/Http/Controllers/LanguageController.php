<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageSwitchRequest;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function languageSwitch(Request $request): void
    {
        session(['locale' => $request->locale]);

    }
}
