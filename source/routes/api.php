<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApplicationProgressController;
use App\Http\Controllers\Api\DocumentTypeController;
use App\Http\Controllers\Api\HomeInstitutionController;
use App\Http\Controllers\Api\HomeInstitutionFormController;
use App\Http\Controllers\Api\MobilityController;
use App\Http\Controllers\Api\PersonalDetailsController;
use App\Http\Controllers\Api\MotivationAndAddedValueController;
use App\Http\Controllers\Api\ProposedHostUniversitiesController;
use App\Http\Controllers\Api\UploadedDocumentController;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify/{code}', [AuthController::class, 'verifyEmail']);
    Route::post('/send-code', [AuthController::class, 'sendVerifyCode']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::prefix('application')->group(function () {
    Route::get('/getAll', [ApplicationController::class, 'getAllApplications']);
    Route::get('', [ApplicationController::class, 'getMyApplications']);
    Route::post('', [ApplicationController::class, 'create']);
    Route::get('/{id}', [ApplicationController::class, 'getById']);
    Route::post('/submit', [ApplicationController::class, 'submitApplication']);
    Route::post('/status', [ApplicationController::class, 'changeApplicationStatus']);
    Route::delete('/{id}', [ApplicationController::class, 'deleteApplication']);
});

Route::prefix('application-progress')->group(function () {
    Route::get('/{application_id}', [ApplicationProgressController::class, 'getByApplicationId']);
    Route::post('/', [ApplicationProgressController::class, 'toggleLock']);
});

Route::prefix('home-institutions')->group(function () {
    Route::get('/', [HomeInstitutionController::class, 'getAll']);
    Route::get('/{id}', [HomeInstitutionController::class, 'getById']);
});

Route::prefix('mobility')->group(function () {
    Route::get('/', [MobilityController::class, 'getAll']);
});

Route::prefix('personal-details')->group(function () {
    Route::get('/{application_id}', [PersonalDetailsController::class, 'getByApplicationId']);
    Route::post('/', [PersonalDetailsController::class, 'createOrUpdate']);
});

Route::prefix('home-institution')->group(function () {
    Route::get('/{application_id}', [HomeInstitutionFormController::class, 'getByApplicationId']);
    Route::post('/', [HomeInstitutionFormController::class, 'createOrUpdate']);
});

Route::prefix('proposed-host-universities')->group(function () {
    Route::get('/{application_id}', [ProposedHostUniversitiesController::class, 'getByApplicationId']);
    Route::post('/', [ProposedHostUniversitiesController::class, 'createOrUpdate']);
});

Route::prefix('motivation-and-added-value')->group(function () {
    Route::get('/{application_id}', [MotivationAndAddedValueController::class, 'getByApplicationId']);
    Route::post('/', [MotivationAndAddedValueController::class, 'createOrUpdate']);
});

Route::prefix('document-types')->group(function () {
    Route::get('/{application_id}', [DocumentTypeController::class, 'getByMobilityType']);
});

Route::prefix('documents-upload')->group(function () {
    Route::get('/{application_id}', [UploadedDocumentController::class, 'getByApplicationId']);
    Route::post('/', [UploadedDocumentController::class, 'createOrUpdate']);
    Route::get('download/{application_id}/{document_name}/{filename}',  [UploadedDocumentController::class, 'download']);
    Route::get('downloadAll/{application_id}',  [UploadedDocumentController::class, 'downloadAll']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
