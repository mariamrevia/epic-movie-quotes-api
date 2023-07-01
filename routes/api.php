<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');

});
route::controller(PasswordResetController::class) ->group(function () {
    Route::post('/forgot-password', 'notify')->name('password.email');
    Route::post('/reset-password', 'update')->name('password.update');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/redirect', [OAuthController::class, 'handleRedirect'])->name('oauth.redirect');
    Route::get('/auth/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');

});


Route::controller(MovieController::class)->group(function () {
    Route::get('/movies', 'show')->name('movies.show_all');
    Route::post('/movies', 'store')->name('movies.store');
    Route::patch('/movies/{movieId}', 'update')->name('movies.update');


});

Route::post('/quotes', [QuoteContoller::class, 'store'])->name('quotes.store');
Route::patch('/quotes{quoteId}', [QuoteContoller::class, 'update'])->name('quotes.store');
