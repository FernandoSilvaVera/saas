<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;

class UsersController extends Controller
{
	public function createUsers()
	{
		$plans = SubscriptionPlan::all();
		return view('createUsers', ['plans' => $plans]);
	}

	public function listUsers()
	{
		$users = User::all();
		return view('listUsers', ['users' => $users]);
	}
}
