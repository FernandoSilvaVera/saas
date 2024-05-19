<?php

namespace App\NewPages;

use App\Ia\OpenAI;
use App\TextToSpeech;
use Illuminate\Support\Facades\File;
use App\Subscription\ManageClientSubscription;

class Subscription
{

	public static function generateNewPages($word, $downloadPath, $userId)
	{
		$word = json_encode($word);

		$conceptualMapHTML = null;
		$summaryHTML = null;
		$questionsHTML = null;

		for ($i = 0; ; $i++) {
			$pathNewHTML = "$downloadPath/$i.html";

			$i0 = $i-3;
			$i1 = $i-2;
			$i2 = $i-1;

			$conceptualMapHTML = "$downloadPath/$i0.html";
			$summaryHTML = "$downloadPath/$i1.html";
			$questionsHTML = "$downloadPath/$i2.html";

			if (!file_exists($pathNewHTML)) {
				break;
			}

		}

		$openai = new OpenAI($word, $downloadPath, $userId);

		$conceptualMap = $openai->conceptualMap($conceptualMapHTML);
		$summary = false;
		$questions = false;

		if(ManageClientSubscription::haveSummaries($userId)){
			$ok = $openai->summary($summaryHTML);
			if($ok){
				ManageClientSubscription::consumeSummaries(1, $userId);
				$summary = 1;
			}
		}

		if(ManageClientSubscription::haveQuestions($userId)){
			$numQuestions = 10;
			$ok = $openai->questions($questionsHTML, $downloadPath, $numQuestions);
			if($ok){
				ManageClientSubscription::consumeQuestions($numQuestions, $userId);
				$questions = $numQuestions;
			}
		}

		return [$conceptualMap, $summary, $questions];

	}

	public static function splitTextWithSense($text) {
		// Definir los caracteres que indican un final de oración o párrafo
		$sentenceEnders = ['.', '!', '?'];

		// Inicializar variables
		$segments = [];
		$currentSegment = '';

		// Iterar a través del texto
		foreach (preg_split('/([.!?]+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) as $sentence) {
			$currentSegment .= $sentence;

			// Verificar si el segmento actual contiene suficientes palabras
			if (str_word_count($currentSegment) >= 100 || in_array(trim(substr($sentence, -1)), $sentenceEnders)) {
				$segments[] = trim($currentSegment);
				$currentSegment = '';
			}
		}

		// Añadir el último segmento si es necesario
		if (!empty($currentSegment)) {
			$segments[] = trim($currentSegment);
		}

		return $segments;
	}


	public static function texToSpeech($contenido, $path, $userId)
	{
		$providers = ['amazon', 'google', 'openai'];
		$providers = ['amazon'];

		$session_id = "1";

		$audioStoragePathMain = $path . "/audio/";

		if (!File::exists($audioStoragePathMain)) {
			File::makeDirectory($audioStoragePathMain, $mode = 0777, true, true);
		}

		$posX = 0;
		$pos = 0;

		$unionFinal = "";

		$textToSpeechContent = [];

		foreach ($contenido as $index => $messages) {
			foreach($messages as $key => $message){
				if($key == "html"){
					$textToSpeechContent[$index] = $message;
				}else{
					$textToSpeechContent[] = "";
					foreach($message as $key2 => $send){
						$textToSpeechContent[$key2] = $send;
					}
				}

			}
		}

		foreach ($textToSpeechContent as $index => $message) {
			foreach ($providers as $provider) {

				$send = $index . " " . $message;
				$segmentos = self::splitTextWithSense($send);

				$audioStoragePath = $audioStoragePathMain . $posX++ . "/";

				if (!File::exists($audioStoragePath)) {
					File::makeDirectory($audioStoragePath, $mode = 0777, true, true);
				}

				$union = "";

				foreach($segmentos as $segmento){
					$result = TextToSpeech::dispatch($audioStoragePath, $segmento, $provider, $pos++);
					$results['audios'][$provider][] = $result;
					$union .= $audioStoragePath . $result['audio'] . "|";
				}
			}
			$finalFileName = "final.mp3";
			$cmd = "ffmpeg -i \"concat:$union\" -acodec copy " . $audioStoragePath . $finalFileName;
			shell_exec($cmd);

			$unionFinal .= $audioStoragePath.$finalFileName . "|";

			$files = glob($audioStoragePath . "*");

			foreach ($files as $file) {
				if (basename($file) !== $finalFileName) {
					unlink($file);
				}
			}
		}
		$finalFileName = "final.mp3";
		$cmd = "ffmpeg -i \"concat:$unionFinal\" -acodec copy " . $audioStoragePathMain . $finalFileName;
		shell_exec($cmd);
	}

}
