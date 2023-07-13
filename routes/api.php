<?php

use App\Http\Controllers\AccountVerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdentificationCardTypeController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTypesController;

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

Route::post('register', [AuthController::class, "register"]);
Route::post('login', [AuthController::class, "login"]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, "logout"]);

    Route::get('user_types', [UserTypesController::class, "index"])->middleware('admin');
    Route::get('user_types/{id}', [UserTypesController::class, "show"])->middleware('admin');


    Route::get('identification_cards', [IdentificationCardTypeController::class, "index"]);

    Route::get('account_verifications', [AccountVerificationController::class, "index"]);
    Route::get('account_verifications/{id}', [AccountVerificationController::class, "show"]);
    Route::post('account_verifications', [AccountVerificationController::class, "store"]);
    Route::put('account_verifications/{id}', [AccountVerificationController::class, "update"]);
    Route::delete('account_verifications/{id}', [AccountVerificationController::class, "archive"]);


    Route::get('units', [UnitController::class, "index"]);
    Route::get('units/{id}', [UnitController::class, "show"]);
    Route::post('units', [UnitController::class, "store"]);
    Route::put('units/{id}', [UnitController::class, "update"]);
    Route::delete('units/{id}', [UnitController::class, "archive"]);


    Route::get('unit_facilities/{id}', [UnitController::class, "unit_facilities"]);
    Route::get('unit_amenities/{id}', [UnitController::class, "unit_amenities"]);
    Route::get('unit_inclusions/{id}', [UnitController::class, "unit_inclusions"]);
    Route::get('unit_rules/{id}', [UnitController::class, "unit_rules"]);
    Route::get('unit_images/{id}', [UnitController::class, "unit_images"]);
    Route::get('unit_subscriptions/{id}', [UnitController::class, "unit_subscriptions"]);
    Route::get('unit_rentals/{id}', [UnitController::class, "unit_rentals"]);

    Route::get('rentals', [RentalController::class, "index"]);
    Route::get('rentals/{id}', [RentalController::class, "show"]);
    Route::post('rentals', [RentalController::class, "store"]);
    Route::put('rentals/{id}', [RentalController::class, "update"]);
    Route::delete('rentals/{id}', [RentalController::class, "archive"]);
});
