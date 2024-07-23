<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\History;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use App\NewPages\Subscription;
use App\WordHelper;
use App\Subscription\ManageClientSubscription;
use App\Models\User;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use App\Jobs\FileDownloadJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\DownloadFile;
use App\Services\PdfWatermarkService;
use App\Ia\OpenAI;
use App\Http\Controllers\PdfController;

class DownloadController extends Controller
{

				public function __construct()
				{
								$this->checkQueueWork();
				}

				private function checkQueueWork()
				{
								$output = shell_exec('ps aux | grep "queue:work" | grep -v "grep"');
								if (empty($output)) {
												$command = 'nohup php ' . base_path('artisan') . ' queue:work --daemon --tries=3 --timeout=3600 --memory=4048 > /dev/null 2>&1 &';
												$output = shell_exec($command);
												if ($output === null) {
												} else {
												}
								} else {
								}
				}

	public function generateHashId()
	{
		$timestamp = time();
		$hashids = new Hashids('tu_salt_personalizado', 10);
		$hash = $hashids->encode($timestamp);
		return $hash;
	}

	public function aplicarMarcaDeAgua($path){

	}

	public function useTemplate($templateId, $path)
	{
		$template = Template::find($templateId);

		if(!$template){
			return;
		}

		$pathCss = $path . "/css/materialize.css";

		if (File::exists($pathCss)) {

			$fontSize = $template->font_size . "px";

			$contenido = File::get($pathCss);
			$contenido_a_anadir = "

				.nav-wrapper{
					background-color: $template->css_top;
				}

				.menuEscritorio {
					background-color: $template->css_left !important;
				}

				.espacioContenido {
					background-color: $template->css_right !important;
				}

				.material-icons{
					color: $template->css_icons !important;
				}

				p{
					font-size: $fontSize !important;
				}

				body{
					font-family: $template->typography !important;
				}

			";
			File::append($pathCss, $contenido_a_anadir);
		} else {
			echo "El archivo no existe.";
		}

		$logo = $path . "/imagenes/logo.png";
		$command = "cp $template->logo_path $logo";

		exec($command);

		$favicon = $path . "/imagenes/favicon.ico";
		exec("cp $template->favicon_path $favicon");

		if($template->marcaDeAguaPath){
			$pdf = $path . "/download.pdf";
			(new PdfWatermarkService())->addWatermark($pdf, $template->marcaDeAguaPath);
		}

		return $template;
	}

	public function getPath($path, $hashId, $user=null)
	{

		$return = null;

		if(!$user){
			$user = auth()->user();
		}

		$user = $user->name;
		switch($path){
			case "PREVIEW_PATH":
				$path = env("PREVIEW_PATH") . "$user";
				$return = "$path/$hashId";
				break;
			case "PREVIEW_URL":
				$path = env("PREVIEW_URL") . "$user";
				$return = "$path/$hashId/0.html";
				break;
			case "DOWNLOAD_PATH":
				$path = env("DOWNLOAD_PATH") . "$user";
				$return = "$path/$hashId";
				break;
			case "USER_FOLDER_PATH":
				$path = env("DOWNLOAD_PATH") . "$user";
				$return = "$path/";
				break;
			case "FILE_PATH":
				$path = env("PREVIEW_PATH") . "$user";
				$return = "$path/";
				break;
			default:
				break;
		}

		if (!file_exists($return)) {
			if (!mkdir($return, 0755, true)) {
			}
		}

		return $return;
	}

	public function hiddenPremiumButtons($path)
	{
		$pathCss = $path . "/css/materialize.css";

		if (File::exists($pathCss)) {
			$contenido = File::get($pathCss);
			$contenido_a_anadir = "

				.premiumButtons {
					display: none !important;
				}

			";
			File::append($pathCss, $contenido_a_anadir);
		} else {
			echo "El archivo no existe.";
		}

	}

	public function downloadQuestions($fileName, $userId, $language, $generateQuestions, $isPdf = false)
	{

		$user = User::find($userId);
		$hashId = $this->generateHashId();
		$downloadPath = $this->getPath("DOWNLOAD_PATH", $hashId, $user);
		if (!is_dir($downloadPath)) {
			mkdir($downloadPath, 0777, true);
		}

		$history = History::where('name', $fileName)->first();

		$word = $this->getPath("FILE_PATH", $hashId, $user) . $fileName;

		if($isPdf){
			$pdfController = new PdfController();
			$word = $pdfController->parsePdfToArray($word);
			$word = json_encode($word->original);
		}else{
			$word = @(new WordHelper)->convertToArray($word);
			$array = [];
			Subscription::orderArray($word, $word);
			$word = json_encode($word);
			$array = array_filter($word);
		}

		if(ManageClientSubscription::haveQuestions($userId)){
			$history->save();
			$numQuestions = $generateQuestions;
			$openai = new OpenAI($word, $downloadPath, $userId, null, $history);

			$filePath = '/tmp/randomFile.txt';
			file_put_contents($filePath, '');

			$ok = $openai->questions($filePath, $numQuestions, null);
			if($ok){
				$history->save();
				$questions = $numQuestions;
			}

			$zipFilePath = $downloadPath;

			$userPath = $this->getPath("DOWNLOAD_PATH", null, $user);
			$command = "cd $userPath && zip -r {$hashId}.zip {$hashId}";
			exec($command);

			if($generateQuestions){
				ManageClientSubscription::consumeQuestions($generateQuestions, $userId);
			}

			$history = History::updateOrCreate(
				['name' => $fileName],
				[
					'userId' => $userId,
					'templateName' => '',
					'wordsUsed' => '',
					'voiceOver' => false,
					'summary' => false,
					'conceptualMap' => false,
					'questionsUsed' => $generateQuestions,
					'pathZip' => $zipFilePath . ".zip",
					"status" => "OK",
				]
			);

		}
	}


	public function download($fileName, $templateId, $userId, $language, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver)
	{
		$history = History::where('name', $fileName)->first();

//		throw new \Exception("depurar errores");

		try {

		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		if($generateQuestions > $clientSubscription->numero_preguntas){
			$generateQuestions = $clientSubscription->numero_preguntas;
		}

		\Log::info('DownloadController Start ' . $language);

		$user = User::find($userId);
		\Log::info('DownloadController user');
		$hashId = $this->generateHashId();
		$hashId = $fileName;
		\Log::info('DownloadController hashId');

		$word = $this->getPath("FILE_PATH", $hashId, $user) . $fileName;
		\Log::info('DownloadController word');

		$scriptPath = resource_path('script/index.php');

		\Log::info('DownloadController getPath before');

		$path = $this->getPath("DOWNLOAD_PATH", $hashId, $user);
		$zipFilePath = $path;
		$userPath = $this->getPath("DOWNLOAD_PATH", null, $user);


		\Log::info('DownloadController getPath after');

		$palabras = @(new WordHelper)->getAllWords($word);
		$title = @(new WordHelper)->getMainTitle($word);

		ManageClientSubscription::getAllWordsUsed($palabras, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver);

		\Log::info('DownloadController fin palabras');

		if(!ManageClientSubscription::haveMaximumWords($palabras, $userId)){
			$history->status= "el fichero es demasiado graned para su plan";
			$history->save();
			\Log::info('DownloadController el fichero es demasiado grande para su plan');
			return false;
		}else{

			$files = scandir($path);
			$files = array_diff($files, array('.', '..'));
			if (empty($files)) {
							\Log::info('Se va a ejecutar el SCRIPT');
							$command = "php {$scriptPath} {$word} {$path}/";
							$output = shell_exec($command);
			}else{
							\Log::info('YA HAY FICHEROS NO EJECUTAMOS EL SCRIPT');
			}
			ManageClientSubscription::consumeMaximumWords($palabras, $userId);


			\Log::info('SCRIPT TERMINADO ' . $command);

			\Log::info('DownloadController use template');
			$template = $this->useTemplate($templateId, $path);

			$history = $this->updateOrCreateHistory($fileName, $userId, $template, false, false, false, false, false, $zipFilePath, $userPath, $hashId, "30%");

//			$history->status= "virtualización normal terminada";
//			$history->save();

		}

		$contenido = @(new WordHelper)->convertToArray($word);

		if($generateVoiceOver && ManageClientSubscription::haveVoiceOver($userId)){
			$history->save();
			\Log::info('VA A EMPEZAR EL PROCESO DE VOZ');
			Subscription::texToSpeech($contenido, $path, $userId, $history);
			$voiceOver = true;
			\Log::info('VOZ TERMINADA');
			$history->status = "50%";
			$history->voiceOverSelected = false;
			$history->save();
		}else{
			$this->hiddenPremiumButtons($path);
			$voiceOver = false;
		}

		\Log::info('VA A EMPEZAR EL PROCESO IA');
		$history->save();

		list($conceptualMap, $summary, $questionsUsed) = Subscription::generateNewPages($contenido, $path, $userId, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver, $history, $language);

		\Log::info('IA TERMINADO');
		$history->status = "IA TERMINADO";
		$history->save();

		\Log::info('VAMOS A GUARDAR EL HISTORIAL ' . $fileName);

		if($conceptualMap){
			ManageClientSubscription::consumeConceptualMap($userId);
		}

		if($summary){
			ManageClientSubscription::consumeSummaries($summary, $userId);
		}

		if($questionsUsed){
			ManageClientSubscription::consumeQuestions($questionsUsed, $userId);
		}

		$history = $this->updateOrCreateHistory($fileName, $userId, $template, $palabras, $voiceOver, $summary, $conceptualMap, $questionsUsed, $zipFilePath, $userPath, $hashId, "100%");
		

		\Log::info('FIN DEL HISTORIAL');

		\Log::info('DownloadController End');

		$user = User::find($userId);
		$email = $user->email;

		Mail::to($email)->send(new DownloadFile());
		\Log::info('Email enviado ' . $email);

//		return response()->download($zipFilePath . ".zip");

		} catch (\Exception $e) {
			$history->status = "ERROR";
			$history->save();
			\Log::info('DownloadController End CON ERROR ' . $e->getMessage());
		}
	}

	public function preview(Request $request)
	{
		$languages = env('LANGUAGES');
		$languages = explode(",", $languages);

		$hashId = $this->generateHashId();

		$archivo = $request->file('fileName');

		$templateId = $request->input('templateId');
		$languageInput = $request->input('languageInput');
		$summaryOptionPreview = $request->input('summaryOptionPreview');
		$generateQuestionsPreview = $request->input('generateQuestionsPreview');
		$generateConceptMapPreview = $request->input('generateConceptMapPreview');
		$useNaturalVoicePreview = $request->input('useNaturalVoicePreview');

		$palabras = 0;
		$title = "";
		if($archivo){
			try {
				$fileName = $archivo->getFilename();
				$origin = $archivo->getPathname();

				$filePath = $this->getPath("FILE_PATH", $hashId) . $fileName;

				$comando = "mv $origin $filePath";
				exec($comando, $output, $return);

				$palabras = @(new WordHelper)->getAllWords($filePath);
				$title = @(new WordHelper)->getMainTitle($filePath);
				$messageWordsUsed = ManageClientSubscription::getAllWordsUsed($palabras, $summaryOptionPreview, $generateQuestionsPreview, $generateConceptMapPreview, $useNaturalVoicePreview);
			} catch (\Exception $e) {

				// Manejar la excepción
				echo "Error al copiar el archivo: " . $e->getMessage();
			}
		}else{
			$fileName = $request->input('filePath');
			$filePath = $this->getPath("FILE_PATH", $hashId) . $fileName;
		}

		$errorShowDownloadButton = "";

		$userId = Auth::id();
		$user = User::find($userId);

		if(!ManageClientSubscription::haveMaximumWords($palabras, $userId) && $user->idProfile == 2){
			$errorShowDownloadButton .= "No dispones de palabras suficientes para generar la virtualización<br>";
		}

		$scriptPath = resource_path('script/index.php');

		$path = $this->getPath("PREVIEW_PATH", $hashId);

		$previewURL = $this->getPath("PREVIEW_URL", $hashId);

		$command = "php {$scriptPath} {$filePath} {$path}/";

		$output = shell_exec($command);

		$templates = Template::all();

		$template = $this->useTemplate($templateId, $path);

		$userId = Auth::id();
		$user = User::find($userId);
		$email = $user->email;

		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		if($clientSubscription){
			$plan = SubscriptionPlan::Find($clientSubscription->plan_contratado);
		}else{
			$plan = new SubscriptionPlan();
		}

		return view('app', [
			'preview' => $previewURL,
			'templates' => $templates,
			'template' => $template,
			'showDownload' => true,
			'filePath' => $fileName,
			'currentSubscription' => $clientSubscription,
			'plan' => $plan,
			'languages' => $languages,
			'isAdmin' => $user->idProfile == 1,

			'messageWordsUsed' => $messageWordsUsed,
			'errorShowDownloadButton' => $errorShowDownloadButton,

			'templateId' => $templateId,
			'languageInput' => $languageInput,
			'summaryOptionPreview' => $summaryOptionPreview,
			'generateQuestionsPreview' => $generateQuestionsPreview,
			'generateConceptMapPreview' => $generateConceptMapPreview,
			'useNaturalVoicePreview' => $useNaturalVoicePreview,

			'title' => $title,
		]);

	}



	public function handleDownload(Request $request)
	{
		// Despachar el trabajo de descarga de archivo
		FileDownloadJob::dispatch(new DownloadController, $request);

		// Redirigir a la ruta '/app'
		return redirect()->route('/app');
	}

	public function updateOrCreateHistory($fileName, $userId, $template, $palabras, $voiceOver, $summary, $conceptualMap, $questionsUsed, $zipFilePath, $userPath, $hashId, $status) {
		$history = History::updateOrCreate(
			['name' => $fileName],
				[
				'userId' => $userId,
				'templateName' => $template ? $template->template_name : '',
				'wordsUsed' => $palabras,
				'voiceOver' => $voiceOver,
				'summary' => $summary,
				'conceptualMap' => $conceptualMap,
				'questionsUsed' => $questionsUsed,
				'pathZip' => $zipFilePath . ".zip",
				"status" => $status,
			]
		);

		$this->createZip($userPath, $hashId);

		return $history;;
	}


	public function createZip($userPath, $hashId) {
		$zipFilePath = "{$userPath}/{$hashId}.zip";

		// Eliminar el archivo ZIP si ya existe
		if (file_exists($zipFilePath)) {
			unlink($zipFilePath);
		}

		// Crear el nuevo archivo ZIP
		$command = "cd $userPath && zip -r {$hashId}.zip {$hashId}";
		exec($command);
	}



}
