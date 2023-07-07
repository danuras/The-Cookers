<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\IngredientController;

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
Route::get('/', [DashboardController::class, 'index']);

Route::post('change-locale', [LocaleController::class, 'changeLocale'])->name('change-locale');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationView'])->name('register'); //clear
    Route::post('register', [AuthController::class, 'register']); //clear

    Route::get('login', [AuthController::class, 'showLoginView'])->name('login'); //clear
    Route::post('login', [AuthController::class, 'login']); //clear


    Route::get('reset-password', [AuthController::class, 'showEnterEmailView'])->name('reset-password');
    Route::post('reset-password', [AuthController::class, 'enterEmail']);

    Route::get('show-verification-code-reset-password', [AuthController::class, 'showVerificationCodeResetPassword']);
    Route::post('send-verification-code-reset-password', [AuthController::class, 'sendVerificationCodeResetPassword'])->name('send-verification-code-reset-password');
    Route::post('verify-code', [AuthController::class, 'verifyCode'])->name('verify-code');

    Route::get('show-enter-new-password', [AuthController::class, 'showEnterNewPassword']);
    Route::post('save-new-password', [AuthController::class, 'saveNewPassword'])->name('save-new-password');
});

Route::middleware(['auth', 'verify-email']) /* ->prefix('{locale}') */->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('send-verification-code', [AuthController::class, 'sendVerificationCode'])->name('send-verification-code'); 
    Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');
    Route::get('show-verification-code', [AuthController::class, 'showVerificationCode'])->name('show-verification-code');
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::resource('profiles', ProfileController::class)->only(['index', 'edit', 'update']);
    Route::get('profiles/{user}/destroy', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    
    Route::prefix('recipes')->group(function () {
        Route::get('{recipe}/detail', [RecipeController::class, 'showDetail']);
        Route::get('user-recipe', [RecipeController::class, 'showUserRecipe'])->name('recipes.user-recipe');
        
        Route::prefix('upload-recipe')->group(function () {
            Route::get('upload-image', [RecipeController::class, 'showUploadImage'])->name('recipes.upload-image');
            Route::post('upload-image', [RecipeController::class, 'uploadImage'])->name('save.recipes.upload-image');
            Route::get('upload-recipe-atribute', [RecipeController::class, 'showUploadRecipeAtribute'])->name('recipes.upload-recipe-atribute');
            Route::post('upload-recipe-atribute', [RecipeController::class, 'uploadRecipeAtribute'])->name('save.recipes.upload-recipe-atribute');
            Route::get('review-upload-recipe', [RecipeController::class, 'showReviewUploadRecipe'])->name('recipes.review-upload-recipe');
            Route::get('finish-upload-recipe', [RecipeController::class, 'showFinishUploadRecipe'])->name('recipes.finish-upload-recipe');
        });

        Route::prefix('search-recipe')->group(function () {
            Route::get('/', [RecipeController::class, 'showSearchRecipe'])->name('recipes.search-recipe');
            Route::get('/{search}/search-result', [RecipeController::class, 'searchRecipeNotDetail'])->name('recipes.result-recipe');
            Route::get('/{name}/{ingredient}/search-result-detail', [RecipeController::class, 'searchRecipeDetail'])->name('recipes.detail-result-recipe');
        });

        Route::prefix('edit-recipe')->group(function () {
            Route::get('edit-image/{recipe}', [RecipeController::class, 'showEditImage'])->name('recipes.edit-image');
            Route::post('edit-image', [RecipeController::class, 'editImage'])->name('save.recipes.edit-image');
            Route::get('edit-recipe-atribute', [RecipeController::class, 'showEditRecipeAtribute'])->name('recipes.edit-recipe-atribute');
            Route::post('edit-recipe-atribute', [RecipeController::class, 'editRecipeAtribute'])->name('save.recipes.edit-recipe-atribute');
            Route::get('review-edit-recipe', [RecipeController::class, 'showReviewEditRecipe'])->name('recipes.review-edit-recipe');
            Route::get('finish-edit-recipe', [RecipeController::class, 'showFinishEditRecipe'])->name('recipes.finish-edit-recipe');
        });

        Route::delete('{recipe}', [RecipeController::class, 'destroy'])->name('recipes.delete');
    });
});
