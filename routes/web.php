<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AppQuestions;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ShareAccountController;
use App\Http\Controllers\ClientsSubscriptionController;
use App\Jobs\FileDownloadJob;
use App\Jobs\QuestionsDownloadJob;
use App\Jobs\ProcessTestJob;
use Illuminate\Http\Request;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PdfController;
use App\Models\Template;
use App\Models\History;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\NewPasswordController;


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
Route::get('/appQuestions', [AppQuestions::class, 'index'])->middleware('auth.redirect')->name('appQuestions');


Route::get('/listProducts', [ProductController::class, 'showAll']);
Route::get('/product', [ProductController::class, 'editProduct'])->name('product');


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

	$debug = env('DEBUG_DOWNLOAD');

	$template = Template::find($templateId);

	$history = new History();
	$history->name = $fileName;
	$history->userId = $userId;

	$history->templateName =" ";

	if($template){
		$history->templateName = $template->template_name;
	}
	$history->status = "En proceso...";
	$history->wordsUsed = "En proceso...";
	$history->voiceOver = $useNaturalVoiceDownload;

	$history->summary = $summaryOptionDownload;
	$history->conceptualMap = $generateConceptMapDownload;
	$history->questionsUsed = $generateQuestionsDownload;

	$history->pathZip = "";
	$history->save();

	if($debug){
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
		return redirect('/queuedDownload');
	}

	FileDownloadJob::dispatch($fileName, $templateId, $userId, $language, $summaryOptionDownload, $generateQuestionsDownload, $generateConceptMapDownload, $useNaturalVoiceDownload);

	return redirect('/queuedDownload');

})->name('download')->middleware('auth.redirect');


Route::post('/downloadQuestions', function (Request $request) {

	\Log::info('Download Start Route Questions');
	$userId = auth()->id();

	$archivo = $request->file('fileName');
	$fileName = $archivo->getFilename();
	$origin = null;
	$isPdf = false;

	if ($archivo->getClientMimeType() == 'application/pdf') {
		$pdfController = new PdfController();
		$isPdf = true;
	} else {
		echo("El archivo no es un PDF.");
	}

	$language = $request->input('languageInputDownload');
	$generateQuestionsDownload = $request->input('generateQuestionsDownload');

	$debug = env('DEBUG_DOWNLOAD');

	$history = new History();
	$history->name = $fileName;
	$history->userId = $userId;
	$history->templateName =" ";
	$history->status = "En proceso...";
	$history->wordsUsed = false;
	$history->voiceOver = false;
	$history->summary = false;
	$history->conceptualMap = false;
	$history->questionsUsed = $generateQuestionsDownload;
	$history->pathZip = "";
	$history->save();

	$d = new DownloadController();

	$hashId = $d->generateHashId();
	$filePath = $d->getPath("FILE_PATH", $hashId) . $fileName;
	if(!$origin){
		$origin = $archivo->getPathname();
	}
	$comando = "mv $origin $filePath";
	exec($comando, $output, $return);

	if($debug){
		$d->downloadQuestions(
			$fileName, 
			$userId,
			$language, 
			$generateQuestionsDownload, 
			$isPdf,
		);
		return redirect('/queuedDownload');
	}

	QuestionsDownloadJob::dispatch($fileName, $userId, $language, $generateQuestionsDownload, $isPdf);

	return redirect('/queuedDownload');

})->name('downloadQuestions')->middleware('auth.redirect');



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

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [
	'as' => 'password.reset',
	'uses' => 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm'
]);

Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.recover');
