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

class AppQuestions extends Controller
{

	public function index($message=null)
	{
		$userId = Auth::id();
		$user = User::find($userId);
		$clientSubscription = ManageClientSubscription::getClientSubscription($userId);
		$templates = Template::where('userId', $userId)->get();
		$languages = env('LANGUAGES');
		$languages = explode(",", $languages);

		if($user->idProfile == 1){
			return $this->viewAdmin($templates, $message, $languages);
		}

		if(!$clientSubscription){
			return view('appQuestions', ['errorMessageSubscription' => true]);
		}

		$email = $user->email;
		$nextDate = "";


		if($clientSubscription->customerStripe){
			$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
			$customer = $stripe->customers->retrieve($clientSubscription->customerStripe, [ 'expand' => ['subscriptions']]);
			$subs = $customer->subscriptions->data;
			$currentSub = end($subs);

			if($currentSub){
				$currentPeriodEnd = Carbon::createFromTimestamp($currentSub->current_period_end);
				$nextDate = $currentPeriodEnd->format('Y-m-d H:i:s');
			}else{
				$nextDate = "Plan Cancelado";
			}

		}

		$plan = SubscriptionPlan::Find($clientSubscription->plan_contratado);

		return view('appQuestions', ['templates' => $templates, 'currentSubscription' => $clientSubscription, 'plan' => $plan, 'message' => $message, "nextDate" => $nextDate, 'languages' => $languages, 'isAdmin' => false]);
	}

	public function viewAdmin($templates, $message, $languages)
	{
		$currentSubscription = new ClientsSubscription();
		$plan = new SubscriptionPlan();
		return view('appQuestions', [
			'templates' => $templates, 
			'message' => $message, 
			'languages' => $languages,
			'currentSubscription' => $currentSubscription,
			'plan' => $plan,
			'isAdmin' => true,
		]);
	}

	public function queuedDownload()
	{
		return $this->index("Tu contenido se está virtualizando. Recibirás un correo cuando esté listo para descargar desde el historial.");
	}


}
