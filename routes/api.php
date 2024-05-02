<?php

use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\SubscriptionPlanController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\TextToSpeechController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/text-to-speech', [TextToSpeechController::class, 'index']);

Route::post('/subscriptions', [SubscriptionController::class, 'createSession']);
Route::post('/subscriptions/webhook/success', [SubscriptionController::class, 'webhookSuccess']);
Route::post('/subscriptions/webhook/cancel', [SubscriptionController::class, 'webhookCancel']);
