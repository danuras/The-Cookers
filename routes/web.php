<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyCRUDController;
use App\Http\Controllers\AuthController;
use App\Mail\SendEmailVerificationCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('dashboard');
});
Route::get('/test', function(){
    Mail::to('salam123.sb27@gmail.com')->send(new SendEmailVerificationCode('hehe'));
    return  view('dashboard');
});
Route::middleware('guest')->group(function () {
    
    Route::get('register', [AuthController::class, 'showRegistrationView'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginView'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    
    Route::get('enter-email', [AuthController::class, 'showEnterEmailView'])->name('enter-email');
    Route::post('enter-email', [AuthController::class, 'enterEmail'])->name('enter-email');

    Route::get('show-verification-code-reset-password', [AuthController::class, 'showVerificationCodeResetPassword']);
    Route::post('send-verification-code-reset-password', [AuthController::class, 'sendVerificationCodeResetPassword'])->name('send-verification-code-reset-password');
    Route::post('verify-code', [AuthController::class, 'verifyCode'])->name('verify-code');

    Route::get('show-enter-new-password', [AuthController::class, 'showEnterNewPassword']);
    Route::post('save-new-password', [AuthController::class, 'saveNewPassword'])->name('save-new-password');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('send-verification-code', [AuthController::class, 'sendVerificationCode'])->name('send-verification-code');
    Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');
    Route::get('show-verification-code', [AuthController::class, 'showVerificationCode'])->name('show-verification-code');

    /*  Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');  */
}); 

