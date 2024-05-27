<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Stripe\PaymentLink;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Subscription\ManageClientSubscription;
use Illuminate\Support\Facades\Http;

class PlansController extends Controller
{
	public function index()
	{
		$userId = Auth::id();

		$plans = SubscriptionPlan::where('is_active', true)
			->where('custom_plan', false)
			->orderBy('monthly_price', 'asc')
			->get();

		if ($userId) {
			$user = User::find($userId);
			if($user->idProfile != 1){

				$clientSubscription = ManageClientSubscription::getClientSubscription($userId);
				if($clientSubscription){
					$active = false;

					$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
					$customer = $stripe->customers->retrieve($clientSubscription->customerStripe, [ 'expand' => ['subscriptions']]);

					foreach($customer->subscriptions->data as $subscription){
						$active = true;
					}

					if($active){
						$clientPlanId = $clientSubscription->plan_contratado;

						$clientPlan = SubscriptionPlan::find($clientPlanId);

						$clientPlan->is_client_plan = true;

						$planExists = $plans->contains('id', $clientPlanId);

						if (!$planExists) {
							$plans->push($clientPlan);
						} else {
							$plans = $plans->map(function ($plan) use ($clientPlanId) {
									if ($plan->id == $clientPlanId) {
									$plan->is_client_plan = true;
									}
									return $plan;
									});
						}

					}

				}


			}
		}

		return view('plans', [
			'plans' => $plans
		]);
	}

	public function buy($id)
	{
		$subscriptionPlan = SubscriptionPlan::where('stripe_monthly_price_id', $id)
			->orWhere('stripe_annual_price_id', $id)
			->first();

		$subscription_plan_id = $subscriptionPlan->id;

		if ($subscriptionPlan) {
			$foundBy = null;
			if ($subscriptionPlan->stripe_monthly_price_id == $id) {
				$payment_period = 'monthly_price';
			} elseif ($subscriptionPlan->stripe_annual_price_id == $id) {
				$payment_period = 'annual_price';
			}
		}

		$userId = Auth::id();
		$user = User::find($userId);
		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		$customer_id = null;
		if($clientSubscription){
			$customer_id = $clientSubscription->customerStripe;
		}

		$data = [
			'subscription_plan_id' => $subscription_plan_id,
			'payment_period' => $payment_period,
			'customer_id' => $customer_id,
			'customer_email' => $user->email,
		];



		$response = Http::post(url('/api/subscriptions'), $data);

		if ($response->successful()) {
			$responseData = $response->json();
			$checkoutUrl = $responseData['url'];
			return redirect($checkoutUrl);
		}else{
			
		}
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
