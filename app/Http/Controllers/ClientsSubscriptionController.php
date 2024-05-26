<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;

class ClientsSubscriptionController extends Controller
{

	public function view(Request $request)
	{
		$id = $request->input('id');
		$client = ClientsSubscription::find($id);
		$plan = SubscriptionPlan::find($client->plan_contratado);

		return view('client', [
			'currentSubscription' => $client,
			'plan' => $plan,
		]);
	}

	public function edit(Request $request){
		$id = $request->input('id');
		$wordLimit = $request->input('word_limit');

		$client = ClientsSubscription::find($id);
		$client->palabras_maximas = $wordLimit;
		$client->save();
		return $this->view($request);
	}

}
