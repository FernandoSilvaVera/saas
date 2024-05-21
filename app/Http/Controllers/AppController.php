<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use App\Subscription\ManageClientSubscription;

class AppController extends Controller
{

	public function index($message=null)
	{
		$userId = Auth::id();
		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);

		$user = User::find($userId);
		$email = $user->email;
		$templates = Template::where('userId', $userId)->get();
		$nextDate = "";

		if($clientSubscription->customerStripe){
			$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
			$customer = $stripe->customers->retrieve($clientSubscription->customerStripe, [ 'expand' => ['subscriptions']]);
			$subs = $customer->subscriptions->data;
			$currentSub = end($subs);

			$currentPeriodEnd = Carbon::createFromTimestamp($currentSub->current_period_end);
			$nextDate = $currentPeriodEnd->format('Y-m-d H:i:s');
		}

		$plan = SubscriptionPlan::Find($clientSubscription->plan_contratado);

		return view('app', ['templates' => $templates, 'currentSubscription' => $clientSubscription, 'plan' => $plan, 'message' => $message, "nextDate" => $nextDate]);
	}

	public function queuedDownload()
	{
		return $this->index("Tu contenido se está virtualizando. Recibirás un correo cuando esté listo para descargar desde el historial.");
	}


}
