<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use Illuminate\Support\Facades\File;

class TemplateController extends Controller
{

	public function listTemplates($message = null)
	{
		$userId = Auth::id();
		$templates = Template::where('userId', $userId)->get();

		return view('templates', [
			'templates' => $templates,
			'message' => $message,
		]);
	}

	public function saveImages(&$data)
	{
		$user = auth()->user();
		$user = $user->name;

		$timestamp = time();
		$hashids = new Hashids('logo', 10);
		$hash1 = $hashids->encode($timestamp);

		$hashids = new Hashids('favicon', 10);
		$hash2 = $hashids->encode($timestamp);

		$pathLogo = env("DOWNLOAD_PATH") . "$user";
		$pathFavico = env("DOWNLOAD_PATH") . "$user";

		if (!file_exists($pathLogo)) {
			if (!mkdir($pathLogo, 0755, true)) {
			}
		}

		$pathLogo .= "/images";
		$pathFavico .= "/images";

		if (!file_exists($pathLogo)) {
			if (!mkdir($pathLogo, 0755, true)) {
			}
		}

		$pathLogo .= "/$hash1.png";
		$pathFavico .= "/$hash2.png";

		list($type, $dataLogo) = explode(';', $data['logo_path']);
		list(, $dataLogo)      = explode(',', $dataLogo);

		$logo_data = base64_decode($dataLogo);
		file_put_contents($pathLogo, $logo_data);

		list($type, $dataFavicon) = explode(';', $data['favicon_path']);
		list(, $dataFavicon)      = explode(',', $dataFavicon);

		$favicon_data = base64_decode($dataFavicon);
		file_put_contents($pathFavico, $favicon_data);

		$data['favicon_path'] = $pathFavico;
		$data['logo_path'] = $pathLogo;
	}

	public function store(Request $request)
	{

		$userId = Auth::id();
		$data = $request->all();
		$data['userId'] = $userId;

		$this->saveImages($data);

		if($data['templateId']){
			$template = Template::findOrFail($data['templateId']);
			$template->update($data);
		}else{
			$template = Template::create($data);
		}


		return response()->json($template, 201);
	}

	public function edit(Request $request)
	{
		$id = $request->input('id');
		$template = Template::find($id);

		if($template){
			$logoBase64 = base64_encode(File::get($template->logo_path));
			$faviconBase64 = base64_encode(File::get($template->favicon_path));

			$template->logo_path = 'data:image/png;base64,' . $logoBase64;
			$template->favicon_path = 'data:image/png;base64,' . $faviconBase64;
		}

		if(!$template){
			$template = new Template();
		}

		return view('template', [
			'template' => $template,
		]);
	}

	public function listTemplatesOkMessage(Request $request)
	{
		return $this->listTemplates("Plantilla guardada");
	}

}
