<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Credito;
use Illuminate\Support\Facades\Auth;
use App\Subscription\ManageClientSubscription;

class ClientsSubscriptionController extends Controller
{

	public function view(Request $request, $message="")
	{
		$id = $request->input('id');
		$client = ClientsSubscription::find($id);
		$plan = SubscriptionPlan::find($client->plan_contratado);

		$user = User::where('email', $client->email)->first();

		$credito = Credito::firstOrNew(['idUsuario' => $user->id]);

		return view('client', [
			'currentSubscription' => $client,
			'plan' => $plan,
			'message' => $message,
			'credito' => $credito,
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

	public function editCredits(Request $request)
	{
		$validatedData = $request->validate([
				'id' => 'required|integer|exists:creditos,id',
				'palabras' => 'required|integer',
				'resumenes' => 'required|integer',
				'mapa' => 'required|integer',
				'preguntas' => 'required|integer',
		]);

		Credito::where('id', $validatedData['id'])->update([
			'palabras' => $validatedData['palabras'],
			'resumenes' => $validatedData['resumenes'],
			'mapa' => $validatedData['mapa'],
			'preguntas' => $validatedData['preguntas'],
		]);

		$credito = Credito::find($validatedData['id']);

		return $this->view($request, "datos actualizados correctamente");
	}
}
