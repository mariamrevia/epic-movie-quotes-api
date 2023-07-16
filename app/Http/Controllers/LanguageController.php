<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageSwitchRequest;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function languageSwitch(Request $request)
    {
        session(['locale' => $request->locale]);

    }
}
