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

		if(!$plan){
			return;
		}

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

		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}

		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->palabras_maximas -= $wordsUsed;
		$clientSubscription->save();
	}

	public static function consumeQuestions($questionsUsed, $userId) {
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		$clientSubscription->numero_preguntas -= $questionsUsed;
		$clientSubscription->save();
	}

	public static function consumeSummaries($summariesUsed, $userId) {
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
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
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();

		if($clientSubscription->subscriptionPlan->unlimited_words){
			return true;
		}

		return $clientSubscription->palabras_maximas > $current;
	}

	public static function haveSummaries($userId){
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();

		return $clientSubscription->subscriptionPlan->summaries;
	}

	public static function haveQuestions($userId){
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();

		return $clientSubscription->subscriptionPlan->test_questions_count;
	}

	public static function haveVoiceOver($userId){
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->subscriptionPlan->voiceover;
	}

	public static function haveConceptualMap($userId){
		$isAdmin = User::isAdmin($userId);
		if($isAdmin){
			return true;
		}
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription->subscriptionPlan->concept_map;
	}


	public static function getClientSubscription($userId)
	{
		$email = self::getEmail($userId);
		$clientSubscription = ClientsSubscription::where('email', $email)->first();
		return $clientSubscription;
	}

	public static function getAllWordsUsed(&$wordsUsed, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver)
	{
		$message = "";
		$wordsUsed = round($wordsUsed);
		$message .= "$wordsUsed en la virtualización<br>";

		if($generateVoiceOver){
			$config = get_config('online_narration_percentage');

			$voiceoverWords = round($wordsUsed * $config/100);
			$wordsUsed += $voiceoverWords;
			$message .= "$voiceoverWords en la locución en línea<br>";
		}

		if($generateSummary){
			$txt = "";

			switch($generateSummary){
				case 1:
					$config = get_config('long_summary_percentage');
					$txt = "en el resumen largo";
					break;
				case 2:
					$config = get_config('short_summary_percentage');
					$txt = "en el resumen corto";
					break;

			}

			$summaryWords = round($wordsUsed * $config/100);
			$wordsUsed += $summaryWords;
			$message .= "$summaryWords $txt<br>";
		}
		if($generateQuestions){
			$config = get_config('questions_percentage');
			$questionsWords = round($wordsUsed * $config/100);
			$wordsUsed += $questionsWords;
			$message .= "$questionsWords en generar preguntas<br>";
		}

		if($generateConceptualMap){
			$config = get_config('concept_map_percentage');
			$conceptualMapWords = round($wordsUsed * $config/100);
			$wordsUsed += $conceptualMapWords;
			$message .= "$conceptualMapWords en el mapa conceptual<br>";
		}

		$return = "Se va a consumir un total de <b>$wordsUsed</b> palabras<br><br>";
		$return .= $message;
		return $return;
	}

}
