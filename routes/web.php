<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/captchalogin', [App\Http\Controllers\CaptchaLoginController::class, 'loginForm'])->name('login.form')->middleware('guest');

Route::post('/captchaloginAuthenticate', [App\Http\Controllers\CaptchaLoginController::class, 'login'])->name('login.Authenticate');

Route::get('/dashboard', [App\Http\Controllers\CaptchaLoginController::class, 'dashboard'])->name('user.dashboard');




Route::get('/otpVerificationPage',  [App\Http\Controllers\CaptchaLoginController::class, 'OTP_VerificationPage'])->name('OTP.verification');

Route::get('/sendOTP/{user}', [App\Http\Controllers\CaptchaLoginController::class, 'sendOTP'])->name('send.OTP');

Route::post('/otpVerify', [App\Http\Controllers\CaptchaLoginController::class, 'verifyOTP'])->name('otp.verify');
