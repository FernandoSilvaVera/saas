<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{


	public function sendEmail(Request $request)
	{
		$request->validate([
			'message' => 'required|string',
		]);

		$message = $request->input('message');

		$emailUs = env('MAIL_US');

		$userEmail = auth()->user()->email;

		// Enviar el correo
		Mail::to($emailUs)->send(new ContactMail((string)$message, $userEmail));

		return back()->with('success', 'Email sent successfully!');
	}


}
