<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{
	public function index()
	{
		// Obtener todas las configuraciones
		$configs = Config::all()->keyBy('key');
		return view('config.index', compact('configs'));
	}

	public function update(Request $request)
	{
		// Validar los datos recibidos
		$request->validate([
			'concept_map_percentage' => 'required|numeric',
			'long_summary_percentage' => 'required|numeric',
			'short_summary_percentage' => 'required|numeric',
			'questions_percentage' => 'required|numeric',
			'online_narration_percentage' => 'required|numeric',
		]);

		// Actualizar las configuraciones
		$data = $request->only([
			'concept_map_percentage',
			'long_summary_percentage',
			'short_summary_percentage',
			'questions_percentage',
			'online_narration_percentage',
		]);

		foreach ($data as $key => $value) {
			Config::updateOrCreate(['key' => $key], ['value' => $value]);
		}

		return redirect()->route('config.index')->with('success', 'Datos guardados correctamente');
	}
}
