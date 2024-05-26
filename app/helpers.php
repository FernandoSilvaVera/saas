<?php

use App\Models\Config;

if (!function_exists('get_config')) {
	function get_config($key)
	{
		$config = Config::where('key', $key)->first();
		return $config ? $config->value : null;
	}
}

if (!function_exists('set_config')) {
	function set_config($key, $value)
	{
		Config::updateOrCreate(
			['key' => $key],
			['value' => $value]
		);
	}
}
