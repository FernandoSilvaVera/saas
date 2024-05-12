<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

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
		echo $history->pathZip;die;
		return response()->download($history->pathZip);
	}

}
