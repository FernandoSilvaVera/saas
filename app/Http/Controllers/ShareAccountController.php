<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\ClientsSubscription;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Subscription\ManageClientSubscription;

class ShareAccountController extends Controller
{

	public function view($message = null)
	{
		$userId = Auth::id();
		$user = User::find($userId);

		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		if(!$clientSubscription){
			return view('shareAccount', ['errorMessageSubscription' => true]);
		}

		if($clientSubscription->otros_usuarios){
			$emails = json_decode($clientSubscription->otros_usuarios);
		}else{
			for($i=0; $i<$clientSubscription->numero_editores; $i++){
				$emails[] = "";
			}
		}

		$owner = $clientSubscription->email == $user->email;

		return view('shareAccount', [
			'message' => $message,
			'editores' => $emails,
			'email' => $user->email,
			'owner' => $owner,
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
