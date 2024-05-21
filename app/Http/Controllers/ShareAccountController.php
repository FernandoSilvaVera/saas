<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\ClientsSubscription;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ShareAccountController extends Controller
{

	public function view($message = null)
	{
		$userId = Auth::id();
		$user = User::find($userId);
		$clientSubscription = ClientsSubscription::where('email', $user->email)->first();

		if($clientSubscription->otros_usuarios){
			$emails = json_decode($clientSubscription->otros_usuarios);
		}else{
			for($i=0; $i<$clientSubscription->numero_editores; $i++){
				$emails[] = "";
			}
		}

		return view('shareAccount', [
			'message' => $message,
			'editores' => $emails,
			'email' => $user->email
		]);
	}


	public function updateShareAccount(Request $request)
	{
		$editores = $request->input('editoresArray');
		$userId = Auth::id();
		$user = User::find($userId);
		$clientSubscription = ClientsSubscription::where('email', $user->email)->first();
		$clientSubscription->otros_usuarios = $editores;
		$clientSubscription->save();
		return $this->view("Editores actualizados correctamente");
	}


}
