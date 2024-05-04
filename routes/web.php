<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DownloadController;


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

require __DIR__.'/auth.php';

Route::get('/', function () {
	return ['Laravel' => app()->version()];
});

Route::get('/', [AppController::class, 'index']);
Route::get('/app', [AppController::class, 'index']);

Route::get('/plans', [PlansController::class, 'index']);
Route::get('/buy/{id}', [PlansController::class, 'buy']);

Route::get('/createUsers', [UsersController::class, 'createUsers']);
Route::get('/listUsers', [UsersController::class, 'listUsers']);

Route::post('/download', [DownloadController::class, 'download'])->name('download');

Route::post('/preview', [DownloadController::class, 'preview'])->name('preview-document');

Route::get('/history', [HistoryController::class, 'listHistory']);

Route::get('/newPlan', function () {
	return view('newPlan');
});

Route::get('/contact', function () {
	return view('contact');
});

Route::get('/template', function () {
	return view('template');
});



Route::get('/account', function () {
	return view('account');
});

Route::get('/customize', function () {
	return view('customize');
});


