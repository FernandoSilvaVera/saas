<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Asegúrate de incluir esto
use App\Http\Controllers\DownloadController;
use App\Jobs\FileDownloadJob;

class HistoryController extends Controller
{

	public function listHistory()
	{
		$user = Auth::user();
		$userId = $user->id;

		$histories = History::where('userId', $userId)
			->orderBy('created_at', 'desc')
			->get();

		return view('history', [
			"histories" => $histories,
		]);
	}

	public function download(Request $request)
	{
		$id = $request->input('id');
		$history = History::find($id);
		return response()->download($history->pathZip);
	}

	public function downloadAiken(Request $request)
	{
		$id = $request->input('id');
		$history = History::find($id);
		return response()->download($history->pathZip);
	}

	public function retry(Request $request)
	{
		$id = $request->input('id');
		$history = History::find($id);
		$history->status = "0% (Reintento)";
		$history->save();

		$template = Template::where('template_name', $history->templateName)->first();

		if($template){
						$templateId = $template->id;
		}else{
						$templateId = null;
		}

		\Log::info('Download Retry Start Route');
		$userId = auth()->id();
		$fileName = $history->name;

		$language = "es-ES";
		$summaryOptionDownload = false;
		$generateQuestionsDownload = false;
		$generateConceptMapDownload = false;
		$useNaturalVoiceDownload = false;

		$debug = env('DEBUG_DOWNLOAD');

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

	}

}
