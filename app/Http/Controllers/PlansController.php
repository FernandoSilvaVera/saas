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
		$plans = SubscriptionPlan::where('is_active', true)
			->where('custom_plan', false)
			->orderBy('monthly_price', 'asc')
			->get();
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

	public function showAll()
	{
		$plans = SubscriptionPlan::orderBy('is_active', 'desc')->get();
		return view('listPlans', ['plans' => $plans]);
	}

	public function editPlan(Request $request)
	{
		$id = $request->input('id');

		if($id){
			$plan = SubscriptionPlan::find($id);
		}else{
			$plan = new SubscriptionPlan();
		}

		return view('newPlan', [
			'plan' => $plan,
		]);
	}

}
