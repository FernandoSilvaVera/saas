<?php

namespace App\Subscription;

use App\Models\ClientsSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageClientSubscription
{
	public static function update($customer)
	{
		$email = $customer->email;
		$subs = $customer->subscriptions->data;
		$currentSub = end($subs);


		self::consumeMaximumWords(1000, $email);
		self::consumeQuestions(3, $email);
		self::consumeSummaries(15, $email);
die("fer");

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
			]);
		}
	}

	public static function consumeMaximumWords($wordsUsed) {
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->palabras_maximas -= $wordsUsed;
		$clientSubscription->save();
	}

	public static function consumeQuestions($questionsUsed) {
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->numero_preguntas -= $questionsUsed;
		$clientSubscription->save();
	}

	public static function consumeSummaries($summariesUsed) {
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->numero_resumenes -= $summariesUsed;
		$clientSubscription->save();
	}

	public static function getEmail(){
		$userId = Auth::id();
		$user = User::find($userId);
		$email = $user->email;
		return $email;
	}

	public static function haveMaximumWords(){
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->palabras_maximas > 0;
	}

	public static function haveQuestions(){
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->numero_preguntas > 0;
	}

	public static function haveSummaries(){
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->numero_resumenes > 0;
	}

	public static function haveVoiceOver(){
		$email = self::getEmail();
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->locucion_en_linea > 0;
	}

}
