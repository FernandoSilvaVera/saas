<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{

	public function index()
	{
		$userId = Auth::id();
		$templates = Template::where('userId', $userId)->get();
		return view('app', ['templates' => $templates]);
	}

}
