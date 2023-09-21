<?php

use App\Models\Rule;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\AccountVerification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\InclusionController;
use App\Http\Controllers\UserTypesController;
use App\Http\Controllers\ReportedUserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\AccountVerificationController;
use App\Http\Controllers\IdentificationCardTypeController;
use App\Http\Controllers\UnitAmenityController;
use App\Http\Controllers\UnitFacilityController;
use App\Http\Controllers\UnitImageController;
use App\Http\Controllers\UnitInclusionController;
use App\Http\Controllers\UnitRuleController;
use App\Http\Controllers\UnitSubscriptionController;
use App\Models\UnitImage;

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
Route::post('forgot_password', [AuthController::class, "updatePassword"]);

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


Route::get('units_stats', [UnitController::class, "unit_stats"]);
Route::get('units', [UnitController::class, "index"]);
Route::get('units/{id}', [UnitController::class, "show"]);
Route::post('units', [UnitController::class, "store"]);
Route::put('units/{id}', [UnitController::class, "update"]);
Route::delete('units/{id}', [UnitController::class, "archive"]);


Route::get('unit_facilities/{id}', [UnitController::class, "unit_facilities"]);
Route::post('unit_facilities', [UnitFacilityController::class, "store"]);
Route::delete('unit_facilities/{id}', [UnitFacilityController::class, "destroy"]);

Route::get('unit_amenities/{id}', [UnitController::class, "unit_amenities"]);
Route::post('unit_amenities', [UnitAmenityController::class, "store"]);
Route::delete('unit_amenities/{id}', [UnitAmenityController::class, "destroy"]);

Route::get('unit_inclusions/{id}', [UnitController::class, "unit_inclusions"]);
Route::post('unit_inclusions', [UnitInclusionController::class, "store"]);
Route::delete('unit_inclusions/{id}', [UnitInclusionController::class, "destroy"]);

Route::get('unit_rules/{id}', [UnitController::class, "unit_rules"]);
Route::post('unit_rules', [UnitRuleController::class, "store"]);
Route::delete('unit_rules/{id}', [UnitRuleController::class, "destroy"]);

Route::get('unit_images/{id}', [UnitController::class, "unit_images"]);
Route::post('unit_images', [UnitImageController::class, "store"]);
Route::delete('unit_images/', [UnitImageController::class, "destroy"]);

Route::get('unit_subscriptions/{id}', [UnitController::class, "unit_subscriptions"]);
Route::post('unit_subscriptions', [UnitSubscriptionController::class, "store"]);
Route::delete('unit_subscriptions/{id}', [UnitSubscriptionController::class, "destroy"]);

Route::get('unit_rentals/{id}', [UnitController::class, "unit_rentals"]);

Route::get('rentals', [RentalController::class, "index"]);


//TODO: Verify sender
Route::get('rentals/{id}', [RentalController::class, "show"]);
Route::post('rentals', [RentalController::class, "store"]);
Route::put('rentals/{id}', [RentalController::class, "update"]);
Route::delete('rentals/{id}', [RentalController::class, "archive"]);
Route::post('terminate-rentals/{id}', [RentalController::class, "terminate"]);

Route::get('landlord-rentals/{id}', [RentalController::class, "landlord_rental_show"]);
Route::get('landlord-tenants/{id}', [RentalController::class, "landlord_tenants"]);
Route::get('landlord_units_stats/{id}', [RentalController::class, "landlord_units_stats"]);
Route::get('landlord_upcoming_events/{id}', [RentalController::class, "landlord_upcoming_events"]);

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
Route::get('chats-images/{room_id}/{fileName}', [ImageController::class, "showChatImage"]);
Route::get('attribute_icons/{fileName}', [ImageController::class, "showIcon"]);
Route::delete('attribute_icons/{fileName}', [ImageController::class, "destroy"]);

Route::post('/google/auth', [GoogleAuthController::class, 'register']);
Route::post('/google/login', [GoogleAuthController::class, 'login']);
Route::post('/facebook/auth', [FacebookAuthController::class, 'register']);
