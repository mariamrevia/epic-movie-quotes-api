<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\OAuthController;
use App\Http\Controllers\auth\PasswordResetController;
use App\Http\Controllers\quote\CommentController;
use App\Http\Controllers\quote\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\quote\QuoteContoller;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\auth\EmailVerificationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(MovieController::class)->group(function () {
        Route::get('/movies', 'index')->name('movies.show_all');
        Route::post('/movies', 'store')->name('movies.store');
        Route::patch('/movies/{movieId}', 'update')->name('movies.update');
        Route::get('/movies/search', 'index')->name('movies.show');
        Route::delete('/movies/{movie}', 'destroy')->name('movies.destory');
    });

    Route::controller(QuoteContoller::class)->group(function () {
        Route::get('/quotes', 'index')->name('quotes.show_all');
        Route::post('/quotes', 'store')->name('quotes.store');
        Route::patch('quotes{quote}', 'update')->name('quotes.update');
        Route::get('/quotes/search', 'show')->name('quotes.show');
        Route::delete('/quotes/{quote}', 'destroy')->name('quotes.destroy');
    });

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::controller(LikeController::class)->group(function () {
        Route::post('/likes', 'store')->name('likes.store');
        Route::delete('/likes/{quoteId}', 'destroy')->name('likes.destroy');

    });
    Route::controller(NotificationController::class)->group(function () {
        Route::post('/notifications/{movie}/like', 'like')->name('notification.like');
        Route::get('/notifications/{user}', 'show')->name('notification.show');
        Route::post('/notifications/{movie}/comment', 'comment')->name('notification.comment');
        Route::patch('/notifications/markread/{user}', 'markread')->name('notification.markread');

    });
});
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('email.verification_verify');
    Route::patch('/user/{user}', 'update')->name('user.update');
});
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
Route::post('/languages/{locale}', [LanguageController::class, 'languageSwitch'])->name('languages.switch');
