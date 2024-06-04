<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use App\Subscription\ManageClientSubscription;

class ClientsSubscriptionController extends Controller
{

	public function view(Request $request, $message="")
	{
		$id = $request->input('id');
		$client = ClientsSubscription::find($id);
		$plan = SubscriptionPlan::find($client->plan_contratado);

		return view('client', [
			'currentSubscription' => $client,
			'plan' => $plan,
			'message' => $message,
		]);
	}

	public function edit(Request $request)
	{
		$id = $request->input('id');
		$wordLimit = $request->input('word_limit');

		$questions = $request->input('questions');
		$summary = $request->input('summary');
		$conceptualMap = $request->input('conceptualMap');

		$client = ClientsSubscription::find($id);
		$client->palabras_maximas = $wordLimit;

		$client->numero_resumenes = $summary;
		$client->numero_mapa_conceptual = $conceptualMap;
		$client->numero_preguntas = $questions;

		$client->save();
		return $this->view($request, "datos actualizados correctamente");
	}

	public function unsubscribe($planId, Request $request)
	{
		$userId = Auth::id();
		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
		$customer = $stripe->customers->retrieve($clientSubscription->customerStripe, [ 'expand' => ['subscriptions']]);
		ManageClientSubscription::update($customer);

		foreach($customer->subscriptions->data as $subscription){
			$stripe->subscriptions->cancel($subscription->id, []);
		}

		return redirect()->route('plans')->with('success', 'Su suscripción ha sido cancelada.');
	}

}
