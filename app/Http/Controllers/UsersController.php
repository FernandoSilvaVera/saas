<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientsSubscription;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	public function createUsers()
	{
		$plans = SubscriptionPlan::all();
		return view('createUsers', ['plans' => $plans]);
	}

	public function listUsers()
	{
		$clients = ClientsSubscription::with('subscriptionPlan')->get();
		return view('listUsers', ['clients' => $clients]);
	}

	public function view(Request $request)
	{
		$userId = Auth::id();
		$user = User::find($userId);
		return view('account', [
			'user' => $user
		]);
	}

	public function updatePassword(Request $request)
	{
		$request->validate([
			'current_password' => 'required',
			'new_password' => 'required|min:8|confirmed',
		]);

		$user = Auth::user();

		if (!Hash::check($request->current_password, $user->password)) {
			return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
		}

		$user->password = Hash::make($request->new_password);
		$user->save();

		return back()->with('success', 'Contraseña actualizada correctamente');
	}

}
