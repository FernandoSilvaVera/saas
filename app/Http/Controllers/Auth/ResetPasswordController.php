<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string|null  $token
	 * @return \Illuminate\View\View
	 */
	public function showResetForm($token = null)
	{
		return view('auth.passwords.reset')->with(
			['token' => $token, 'email' => request()->email]
		);
	}
}
