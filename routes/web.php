<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ShareAccountController;
use App\Http\Controllers\ClientsSubscriptionController;
use App\Jobs\FileDownloadJob;
use App\Jobs\ProcessTestJob;
use Illuminate\Http\Request;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ContactController;


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

Route::get('/app', [AppController::class, 'index'])->middleware('auth.redirect')->name('app');

Route::get('/listPlans', [PlansController::class, 'showAll']);
Route::get('/plans', [PlansController::class, 'index'])->name('plans');
Route::get('/buy/{id}', [PlansController::class, 'buy'])->middleware('auth.redirect');

Route::get('/changePlanStatus', [PlansController::class, 'index'])->name('plan.changeStatus');
Route::get('/plan', [PlansController::class, 'editPlan'])->name('plan');


Route::get('/createUsers', [UsersController::class, 'createUsers'])->middleware('auth.redirect');
Route::get('/listUsers', [UsersController::class, 'listUsers'])->middleware('auth.redirect');

Route::get('/historyDownload', [HistoryController::class, 'download'])->name('history.download')->middleware('auth.redirect');
Route::get('/historyDownloadAiken', [HistoryController::class, 'downloadAiken'])->name('history.downloadAiken')->middleware('auth.redirect');

Route::post('/preview', [DownloadController::class, 'preview'])->name('preview-document')->middleware('auth.redirect');

Route::get('/history', [HistoryController::class, 'listHistory'])->middleware('auth.redirect');

Route::get('/shareAccount', [ShareAccountController::class, 'view'])->middleware('auth.redirect');

Route::get('/templatesOk', [TemplateController::class, 'listTemplatesOkMessage'])->middleware('auth.redirect');

Route::get('/templates', [TemplateController::class, 'listTemplates'])->middleware('auth.redirect');





Route::get('/contact', function () {
	return view('contact');
})->middleware('auth.redirect');



Route::get('/customize', function () {
	return view('customize');
})->middleware('auth.redirect');


Route::post('/newTemplate', [TemplateController::class, 'store'])->name('template.new')->middleware('auth.redirect');

Route::get('/template', [TemplateController::class, 'edit'])->name('template.edit')->middleware('auth.redirect');

Route::post('/updateShareAccount', [ShareAccountController::class, 'updateShareAccount'])->name('updateShareAccount')->middleware('auth.redirect');

Route::get('/queuedDownload', [AppController::class, 'queuedDownload'])->name('queuedDownload')->middleware('auth.redirect');

Route::post('/downloadDebug', [AppController::class, 'download'])->name('downloadDebug')->middleware('auth.redirect');

Route::post('/download', function (Request $request) {

	\Log::info('Download Start Route');
	$userId = auth()->id();
	$fileName = $request->input('filePath');
	$templateId = $request->input('templateId');

	$language = $request->input('languageInputDownload');
	$summaryOptionDownload = $request->input('summaryOptionDownload');
	$generateQuestionsDownload = $request->input('generateQuestionsDownload');
	$generateConceptMapDownload = $request->input('generateConceptMapDownload');
	$useNaturalVoiceDownload = $request->input('useNaturalVoiceDownload');

/*
	$d = new DownloadController();
	$d->download(
		$fileName, 
		$templateId, 
		$userId,
		$language,
		$summaryOptionDownload,
		$generateQuestionsDownload,
		$generateConceptMapDownload,
		$useNaturalVoiceDownload,
	);
	die;
*/

	FileDownloadJob::dispatch($fileName, $templateId, $userId, $language, $summaryOptionDownload, $generateQuestionsDownload, $generateConceptMapDownload, $useNaturalVoiceDownload);

	return redirect('/queuedDownload');

})->name('download')->middleware('auth.redirect');



Route::get('/test-queue', function () {
	ProcessTestJob::dispatch();
	return 'Job dispatched to the queue.';
});



Route::get('/send-email', function () {
	$email = "fernandosilv4c@gmail.com";
	Mail::to($email)->send(new DownloadFile());
	return "Correo enviado correctamente";
});


Route::get('/client', function () {
	return view('client');
})->middleware('auth.redirect')->name('client');


Route::get('/client', [ClientsSubscriptionController::class, 'view'])->name('client')->middleware('auth.redirect');
Route::post('/clientEdit', [ClientsSubscriptionController::class, 'edit'])->name('client.edit')->middleware('auth.redirect');


Route::get('/account', [UsersController::class, 'view'])->name('user.view')->middleware('auth.redirect');
Route::put('/update-password', [UsersController::class, 'updatePassword'])->name('password.update');



Route::get('/config', [ConfigController::class, 'index'])->name('config.index');
Route::post('/config', [ConfigController::class, 'update'])->name('config.update');


Route::post('/send-email-us', [ContactController::class, 'sendEmail'])->name('send.email');

Route::get('/unsubscribe/{planId}', [ClientsSubscriptionController::class, 'unsubscribe'])->name('unsubscribe');

