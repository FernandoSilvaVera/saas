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


class DownloadController extends Controller
{

	public function generateHashId()
	{
		$timestamp = time();
		$hashids = new Hashids('tu_salt_personalizado', 10);
		$hash = $hashids->encode($timestamp);
		return $hash;
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

	public function download($fileName, $templateId, $userId, $language, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver)
	{
		try {

		\Log::info('DownloadController Start ' . $language);

		$user = User::find($userId);
		\Log::info('DownloadController user');
		$hashId = $this->generateHashId();
		\Log::info('DownloadController hashId');

		$word = $this->getPath("FILE_PATH", $hashId, $user) . $fileName;
		\Log::info('DownloadController word');

		$scriptPath = resource_path('script/index.php');

		\Log::info('DownloadController getPath before');
		$path = $this->getPath("DOWNLOAD_PATH", $hashId, $user);
		$userPath = $this->getPath("DOWNLOAD_PATH", null, $user);
		\Log::info('DownloadController getPath after');

		$palabras = @(new WordHelper)->getAllWords($word);
		ManageClientSubscription::getAllWordsUsed($palabras, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver);

		\Log::info('DownloadController fin palabras');

		if(!ManageClientSubscription::haveMaximumWords($palabras, $userId)){
			\Log::info('DownloadController el fichero es demasiado grande para su plan');
			return false;
		}else{
			\Log::info('Se va a ejecutar el SCRIPT');
			$command = "php {$scriptPath} {$word} {$path}/";
			$output = shell_exec($command);
			ManageClientSubscription::consumeMaximumWords($palabras, $userId);
			\Log::info('SCRIPT TERMINADO ' . $command);

			\Log::info('DownloadController use template');
			$template = $this->useTemplate($templateId, $path);
		}

		$contenido = @(new WordHelper)->convertToArray($word);

		\Log::info('VA A EMPEZAR EL PROCESO IA');
		list($conceptualMap, $summary, $questionsUsed) = Subscription::generateNewPages($contenido, $path, $userId, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver);
		\Log::info('IA TERMINADO');

		if($generateVoiceOver && ManageClientSubscription::haveVoiceOver($userId)){
			\Log::info('VA A EMPEZAR EL PROCESO DE VOZ');
			Subscription::texToSpeech($contenido, $path, $userId);
			$voiceOver = true;
			\Log::info('VOZ TERMINADA');
		}else{
			$this->hiddenPremiumButtons($path);
			$voiceOver = false;
		}

		$zipFilePath = $path;

		$command = "cd $userPath && zip -r {$hashId}.zip {$hashId}";
		exec($command);

		\Log::info('VAMOS A GUARDAR EL HISTORIAL');
		$history = new History();
		$history->name = ' ';
		$history->userId = $userId;
		$history->templateName =" ";

		if($template){
			$history->templateName = $template->template_name;
		}
		$history->wordsUsed = $palabras;
		$history->voiceOver = $voiceOver;

		$history->summary = $summary;
		$history->conceptualMap = $conceptualMap;
		$history->questionsUsed = $questionsUsed;

		$history->pathZip = $zipFilePath . ".zip";
		$history->save();
		\Log::info('FIN DEL HISTORIAL');

		\Log::info('DownloadController End');


		$user = User::find($userId);
		$email = $user->email;

		Mail::to($email)->send(new DownloadFile());
		\Log::info('Email enviado ' . $email);

//		return response()->download($zipFilePath . ".zip");

		} catch (\Exception $e) {
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
		if($archivo){
			try {
				$fileName = $archivo->getFilename();
				$origin = $archivo->getPathname();

				$filePath = $this->getPath("FILE_PATH", $hashId) . $fileName;

				$comando = "mv $origin $filePath";
				exec($comando, $output, $return);

				$palabras = @(new WordHelper)->getAllWords($filePath);
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
			$errorShowDownloadButton = "No disponene de palabras suficientes para generar la virtualización";
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
		]);

	}



	public function handleDownload(Request $request)
	{
		// Despachar el trabajo de descarga de archivo
		FileDownloadJob::dispatch(new DownloadController, $request);

		// Redirigir a la ruta '/app'
		return redirect()->route('/app');
	}




}
