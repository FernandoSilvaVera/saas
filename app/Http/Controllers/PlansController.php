<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Stripe\PaymentLink;
use Stripe\Stripe;

class PlansController extends Controller
{
	public function index()
	{
		$plans = SubscriptionPlan::all();
		return view('plans', ['plans' => $plans]);
	}

	public function buy($id)
	{
		Stripe::setApiKey(config('services.stripe.secret'));
		$link = $response = PaymentLink::create([
				'line_items' => [
				[
				'price' => $id,
				'quantity' => 1,
				],
				],
		]);
		return redirect($link->url);
	}

}
