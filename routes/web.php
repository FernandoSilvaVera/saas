<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TemplateController;


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
})->middleware('auth.redirect');

Route::get('/', function () {
	return redirect('/app');
})->middleware('auth.redirect');

Route::get('/app', [AppController::class, 'index'])->middleware('auth.redirect');

Route::get('/plans', [PlansController::class, 'index']);
Route::get('/buy/{id}', [PlansController::class, 'buy'])->middleware('auth.redirect');

Route::get('/createUsers', [UsersController::class, 'createUsers'])->middleware('auth.redirect');
Route::get('/listUsers', [UsersController::class, 'listUsers'])->middleware('auth.redirect');

Route::get('/historyDownload', [HistoryController::class, 'download'])->name('history.download')->middleware('auth.redirect');
Route::get('/historyDownloadAiken', [HistoryController::class, 'downloadAiken'])->name('history.downloadAiken')->middleware('auth.redirect');


Route::post('/preview', [DownloadController::class, 'preview'])->name('preview-document')->middleware('auth.redirect');

Route::get('/history', [HistoryController::class, 'listHistory'])->middleware('auth.redirect');

Route::get('/templates', [TemplateController::class, 'listTemplates'])->middleware('auth.redirect');

Route::get('/newPlan', function () {
	return view('newPlan');
})->middleware('auth.redirect');

Route::get('/contact', function () {
	return view('contact');
})->middleware('auth.redirect');

Route::get('/account', function () {
	return view('account');
})->middleware('auth.redirect');

Route::get('/customize', function () {
	return view('customize');
})->middleware('auth.redirect');


Route::post('/newTemplate', [TemplateController::class, 'store'])->name('template.new')->middleware('auth.redirect');

Route::get('/template', [TemplateController::class, 'edit'])->name('template.edit')->middleware('auth.redirect');


Route::post('/download', [DownloadController::class, 'download'])->name('download')->middleware('auth.redirect');
