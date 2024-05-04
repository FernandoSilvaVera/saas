<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{

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
		return $template;
	}

	public function getPath($path)
	{
		$user = "fernando";
		switch($path){
			case "PREVIEW_PATH":
				$path = env("PREVIEW_PATH") . "$user";
				$id = 1;
				return "$path/$id";
			case "PREVIEW_URL":
				$path = env("PREVIEW_URL") . "$user";
				$id = 1;
				return "$path/$id/0.html";
			case "DOWNLOAD_PATH":
				$path = env("DOWNLOAD_PATH") . "$user";
				$id = 2;
				return "$path/$id";
			case "FILE_PATH":
				$path = env("PREVIEW_PATH") . "$user";
				return "$path/";
			default:
				break;
		}
		return null;
	}

	public function download(Request $request)
	{
		$templateId = $request->query('templateId');

		$scriptPath = resource_path('script/index.php');
		$filename = resource_path('script/test_1.docx');

		$path = $this->getPath("DOWNLOAD_PATH");

		$command = "php {$scriptPath} {$filename} {$path}";

		$output = shell_exec($command);

		$this->useTemplate($templateId, $path);


		$zipFilePath = $path;
		$command = "zip -r {$zipFilePath} {$path}";
		exec($command);

		return response()->download($zipFilePath . ".zip");

		$templates = Template::all();
		return view('app', [
			"templates" => $templates,
		]);
	}

	public function preview(Request $request)
	{
		$templateId = $request->input('templateId');
		$archivo = $request->file('fileName');

		if($archivo){
			try {
				$fileName = $archivo->getFilename();
				$origin = $archivo->getPathname();

				$filePath = $this->getPath("FILE_PATH") . $fileName;

				$comando = "mv $origin $filePath";
				exec($comando, $output, $return);
			} catch (\Exception $e) {
				// Manejar la excepción
				echo "Error al copiar el archivo: " . $e->getMessage();
			}
		}else{
			$fileName = $request->input('filePath');
			$filePath = $this->getPath("FILE_PATH") . $fileName;
		}

		$scriptPath = resource_path('script/index.php');

		$path = $this->getPath("PREVIEW_PATH");

		$previewURL = $this->getPath("PREVIEW_URL");

		$command = "php {$scriptPath} {$filePath} {$path}";

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

	public function downloadById($id)
	{

	}

}
