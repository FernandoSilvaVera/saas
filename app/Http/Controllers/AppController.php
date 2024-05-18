<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;

class AppController extends Controller
{

	public function index()
	{
		$userId = Auth::id();
		$user = User::find($userId);
		$email = $user->email;
		$templates = Template::where('userId', $userId)->get();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();

		$plan = SubscriptionPlan::Find($clientSubscription->plan_contratado);

		return view('app', ['templates' => $templates, 'currentSubscription' => $clientSubscription, 'plan' => $plan]);
	}

}
