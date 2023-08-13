<?php

use App\Http\Controllers\AccountVerificationController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\IdentificationCardTypeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InclusionController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportedUserController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTypesController;
use App\Models\AccountVerification;
use App\Models\Facility;
use App\Models\Rule;

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
});


Route::get('users', [UserController::class, "index"]);
Route::get('users/{id}', [UserController::class, "show"]);
Route::get('user_units/{id}', [UserController::class, "user_units"]);

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

Route::get('rentals', [RentalController::class, "index"])->middleware('admin');


//TODO: Verify sender
Route::get('rentals/{id}', [RentalController::class, "show"]);
Route::post('rentals', [RentalController::class, "store"]);
Route::put('rentals/{id}', [RentalController::class, "update"]);
Route::delete('rentals/{id}', [RentalController::class, "archive"]);


Route::get('amenities', [AmenityController::class, "index"]);
Route::get('amenities/{id}', [AmenityController::class, "show"]);
Route::post('amenities', [AmenityController::class, "store"]);
Route::put('amenities/{id}', [AmenityController::class, "update"]);
Route::delete('amenities/{id}', [AmenityController::class, "destroy"]);

Route::get('facilities', [FacilityController::class, "index"]);
Route::get('facilities/{id}', [FacilityController::class, "show"]);
Route::post('facilities', [FacilityController::class, "store"]);
Route::put('facilities/{id}', [FacilityController::class, "update"]);
Route::delete('facilities/{id}', [FacilityController::class, "destroy"]);

Route::get('inclusions', [InclusionController::class, "index"]);
Route::get('inclusions/{id}', [InclusionController::class, "show"]);
Route::post('inclusions', [InclusionController::class, "store"]);
Route::put('inclusions/{id}', [InclusionController::class, "update"]);
Route::delete('inclusions/{id}', [InclusionController::class, "destroy"]);

Route::get('rules', [RuleController::class, "index"]);
Route::get('rules/{id}', [RuleController::class, "show"]);
Route::post('rules', [RuleController::class, "store"]);
Route::put('rules/{id}', [RuleController::class, "update"]);
Route::delete('rules/{id}', [RuleController::class, "destroy"]);

Route::get('subscriptions', [SubscriptionController::class, "index"]);
Route::get('subscriptions/{id}', [SubscriptionController::class, "show"]);
Route::put('subscriptions/{id}', [SubscriptionController::class, "update"]);


// Route::get('user_reports', [ReportedUserController::class, "index"]);
Route::get('user_reports', [ReportedUserController::class, "reported_user_group"]);
Route::get('user_reports/{id}', [ReportedUserController::class, "reported_user_group_show"]);


Route::get('landlord_verifications', [AccountVerificationController::class, "index"]);
Route::get('landlord_verifications/{id}', [AccountVerificationController::class, "landlord_verification"]);

Route::post('image-upload', [ImageController::class, "store"]);
Route::get('images', [ImageController::class, "index"]);
Route::get('images/{fileName}', [ImageController::class, "showImage"]);
Route::get('attribute_icons/{fileName}', [ImageController::class, "showIcon"]);
Route::delete('attribute_icons/{fileName}', [ImageController::class, "destroy"]);
