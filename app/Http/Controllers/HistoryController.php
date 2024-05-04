<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{

	public function listHistory()
	{
		return view('history', [
		]);
	}

}
