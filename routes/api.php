<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\SubscriptionPlanController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\TextToSpeechController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/histories', [HistoryController::class, 'index']);
Route::post('/histories', [HistoryController::class, 'store']);

Route::post('/contacts', [ContactController::class, 'store']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

Route::get('/templates', [TemplateController::class, 'index']);
Route::post('/templates', [TemplateController::class, 'store']);
Route::put('/templates/{id}', [TemplateController::class, 'update']);
Route::delete('/templates/{id}', [TemplateController::class, 'destroy']);

Route::get('/subscription/plans', [SubscriptionPlanController::class, 'index']);
Route::post('/subscription/plans', [SubscriptionPlanController::class, 'store']);
Route::put('/subscription/plans/{id}', [SubscriptionPlanController::class, 'update']);
Route::delete('/subscription/plans/{id}', [SubscriptionPlanController::class, 'destroy']);



Route::post('/plan/desactive', [SubscriptionPlanController::class, 'desactive'])->name('plan.desactivar');
Route::post('/plan/active', [SubscriptionPlanController::class, 'active'])->name('plan.activar');



Route::post('/text-to-speech', [TextToSpeechController::class, 'index']);

Route::post('/subscriptions', [SubscriptionController::class, 'createSession']);
Route::post('/subscriptions/webhook/success', [SubscriptionController::class, 'webhookSuccess']);
Route::post('/subscriptions/webhook/cancel', [SubscriptionController::class, 'webhookCancel']);





Route::post('/subscriptions/webhook/successProduct', [SubscriptionController::class, 'webhookSuccessProduct']);







