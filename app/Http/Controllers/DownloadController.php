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

	public function getPath($path, $hashId)
	{

		$return = null;

		$user = auth()->user();

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

	public function download(Request $request)
	{
		$userId = Auth::id();
		$hashId = $this->generateHashId();

		$fileName = $request->input('filePath');
		$filename = $this->getPath("FILE_PATH", $hashId) . $fileName;

		$templateId = $request->input('templateId');

		$scriptPath = resource_path('script/index.php');

		$path = $this->getPath("DOWNLOAD_PATH", $hashId);
		$userPath = $this->getPath("DOWNLOAD_PATH", null);

		$command = "php {$scriptPath} {$filename} {$path}/";

		$output = shell_exec($command);

		$template = $this->useTemplate($templateId, $path);

		$word = $path . "/" . $fileName;

		$contenido = @(new WordHelper)->convertToArray($word);

		if(true){
			Subscription::generateNewPages($contenido, $path, $userId);
			Subscription::texToSpeech($contenido, $path, $userId);
		}else{
			$this->hiddenPremiumButtons($path);
		}

		$zipFilePath = $path;

		$command = "cd $userPath && zip -r {$hashId}.zip {$hashId}";
		exec($command);

		$history = new History();
		$history->name = ' ';
		$history->userId = $userId;
		$history->templateName =" ";

		if($template){
			$history->templateName = $template->template_name;
		}
		$history->pathZip = $zipFilePath . ".zip";
		$history->save();

		return response()->download($zipFilePath . ".zip");
	}

	public function preview(Request $request)
	{

		$hashId = $this->generateHashId();

		$templateId = $request->input('templateId');
		$archivo = $request->file('fileName');

		if($archivo){
			try {
				$fileName = $archivo->getFilename();
				$origin = $archivo->getPathname();

				$filePath = $this->getPath("FILE_PATH", $hashId) . $fileName;

				$comando = "mv $origin $filePath";
				exec($comando, $output, $return);
			} catch (\Exception $e) {
				// Manejar la excepción
				echo "Error al copiar el archivo: " . $e->getMessage();
			}
		}else{
			$fileName = $request->input('filePath');
			$filePath = $this->getPath("FILE_PATH", $hashId) . $fileName;
		}

		$scriptPath = resource_path('script/index.php');

		$path = $this->getPath("PREVIEW_PATH", $hashId);

		$previewURL = $this->getPath("PREVIEW_URL", $hashId);

		$command = "php {$scriptPath} {$filePath} {$path}/";

		$output = shell_exec($command);

		$templates = Template::all();

		$template = $this->useTemplate($templateId, $path);

		return view('app', [
			'preview' => $previewURL,
			'templates' => $templates,
			'template' => $template,
			'showDownload' => true,
			'filePath' => $fileName,
		]);
	}

}
