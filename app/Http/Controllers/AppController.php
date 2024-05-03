<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class AppController extends Controller
{

	public function index()
	{
		$templates = Template::all();
		return view('app', ['templates' => $templates]);
	}

}
