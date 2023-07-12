<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteContoller;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\EmailVerificationController;

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
    Route::post('logout', 'logout')->name('logout');

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
    Route::get('/movies/search', 'show')->name('movies.show');
    Route::delete('/movies/{movie}', 'destroy')->name('movies.destory');
});

Route::controller(QuoteContoller::class)->group(function () {
    Route::get('/quotes', 'show')->name('quotes.show_all');
    Route::post('/quotes', 'store')->name('quotes.store');
    Route::patch('quotes{quoteId}', 'update')->name('quotes.update');
    Route::get('/quotes/search', 'show')->name('quotes.show');
    Route::delete('/quotes/{quote}', 'destroy')->name('quotes.destroy');
});

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::controller(LikeController::class)->group(function () {
    Route::post('/likes', 'store')->name('likes.store');
    Route::delete('/likes/{quoteId}', 'destroy')->name('likes.destroy');

});


Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');

Route::controller(UserController::class)->group(function () {
    Route::get('/profile/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('email.verification_verify');
    Route::patch('/user/{user}', 'updateUserInfo')->name('user.update');
});
