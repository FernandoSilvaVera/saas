<?php

namespace App\Subscription;

use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;

class ManageClientSubscription
{
	//Cuando alguien se suscribe o se renueva
	public static function update($customer)
	{
		$email = $customer->email;
		$subs = $customer->subscriptions->data;
		$currentSub = end($subs);

		$plan = SubscriptionPlan::where('stripe_product_id', $currentSub->plan->product)->first();

		$clientSubscription = ClientsSubscription::where('email', $email)->first();

		if ($clientSubscription) {
			$clientSubscription->update([
					'palabras_maximas' => $plan->word_limit,
					'numero_editores' => $plan->editors_count,
					'numero_preguntas' => $plan->test_questions_count,
					'numero_resumenes' => $plan->summaries,
					'locucion_en_linea' => $plan->voiceover,
					'plan_contratado' => $plan->id,
					'customerStripe' => $currentSub->customer,
			]);
		} else {
			$clientSubscription = ClientsSubscription::create([
					'email' => $email,
					'palabras_maximas' => $plan->word_limit,
					'numero_editores' => $plan->editors_count,
					'numero_preguntas' => $plan->test_questions_count,
					'numero_resumenes' => $plan->summaries,
					'locucion_en_linea' => $plan->voiceover,
					'otros_usuarios' => "",
					'plan_contratado' => $plan->id,
					'customerStripe' => $currentSub->customer,
			]);
		}
	}

	public static function consumeMaximumWords($wordsUsed, $userId) {
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->palabras_maximas -= $wordsUsed;
		$clientSubscription->save();
	}

	public static function consumeQuestions($questionsUsed, $userId) {
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->numero_preguntas -= $questionsUsed;
		$clientSubscription->save();
	}

	public static function consumeSummaries($summariesUsed, $userId) {
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->numero_resumenes -= $summariesUsed;
		$clientSubscription->save();
	}

	public static function getEmail($userId){
		$user = User::find($userId);
		$email = $user->email;

		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		if($clientSubscription){
			return $email;
		}

		$clientSubscription = ClientsSubscription::where('otros_usuarios', 'like', '%' . $email . '%')->first();
		if($clientSubscription){
			return $clientSubscription->email;
		}

		return null;
	}

	public static function haveMaximumWords($current, $userId){
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->palabras_maximas > $current;
	}

	public static function haveQuestions($userId){
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->numero_preguntas > 0;
	}

	public static function haveSummaries($userId){
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->numero_resumenes > 0;
	}

	public static function haveVoiceOver($userId){
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->locucion_en_linea > 0;
	}


	public static function getClientSubscription($userId)
	{
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription;
	}



}
