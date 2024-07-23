<?php

namespace App\NewPages;

use App\Ia\OpenAI;
use App\TextToSpeech;
use Illuminate\Support\Facades\File;
use App\Subscription\ManageClientSubscription;

class Subscription
{

	public static function generateNewPages($word, $downloadPath, $userId, $generateSummary, $generateQuestions, $generateConceptualMap, $generateVoiceOver, $history, $language="es-ES")
	{
		$array = [];
		self::orderArray($word, $array);

		$array = array_filter($array);
		$word = json_encode($array);

		$conceptualMapHTML = null;
		$summaryHTML = null;
		$questionsHTML = null;
		
		$conceptualMapHTMLScorm = null;
		$summaryHTMLScorm = null;
		$questionsHTMLScorm = null;
		
		$scormZip = null;

		for ($i = 0; ; $i++) {
			$pathNewHTML = "$downloadPath/$i.html";

			$i0 = $i-3;
			$i1 = $i-2;
			$i2 = $i-1;

			$scormZip = "$downloadPath/scorm.zip";

			$conceptualMapHTMLScorm = "$i0.html";
			$summaryHTMLScorm = "$i1.html";
			$questionsHTMLScorm = "$i2.html";

			$conceptualMapHTML = "$downloadPath/$i0.html";
			$summaryHTML = "$downloadPath/$i1.html";
			$questionsHTML = "$downloadPath/$i2.html";

			if (!file_exists($pathNewHTML)) {
				break;
			}

		}

		$openai = new OpenAI($word, $downloadPath, $userId, $scormZip, $history);
		$openai->openScorm();

		$summary = false;
		$questions = false;
		$conceptualMap = false;

		if($generateConceptualMap){
			if(ManageClientSubscription::haveConceptualMap($userId)){
				$history->status = "Se va a generar el mapa conceptual";
				$history->save();
				\Log::info('IA CONCEPTUAL MAP NEW');
				$ok = $openai->conceptualMap($conceptualMapHTML, $conceptualMapHTMLScorm, $language);
				if($ok){
					$conceptualMap = 1;
					$history->status = "Mapa conceptual generado";
					$history->save();
				}
			}else{
				\Log::info('no hay creditos para el conceptual map');

			}
		}else{
			\Log::info('NO HAY FLAG PARA GENERAR EL CONCEPTUAL MAP');
		}



		if($generateSummary){
			if(ManageClientSubscription::haveSummaries($userId)){
				$history->status = "Se va a generar el resumen";
				$history->save();
				\Log::info('IA RESUMEN');
				$ok = $openai->summary($summaryHTML, $summaryHTMLScorm, $language);
				if($ok){
					$summary = 1;
					$history->status = "Resumen creado";
					$history->save();
				}
			}

		}

		if($generateQuestions){
			if(ManageClientSubscription::haveQuestions($userId)){
				$history->status = "Se van a generar las preguntas";
				$history->save();
				\Log::info('IA PREGUNTAS');
				$numQuestions = $generateQuestions;
				$ok = $openai->questions($questionsHTML, $numQuestions, $questionsHTMLScorm, $language);
				if($ok){
					$history->status = "Preguntas generadas";
					$history->save();
					$questions = $numQuestions;
				}
			}
		}

		$openai->closeScorm();

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


	public static function orderArray($contenido, &$textToSpeechContent)
	{

		foreach ($contenido as $index => $messages) {
			foreach($messages as $key => $message){
				if($key == "html"){
					$textToSpeechContent[$index] = $message;
				}else{
//					$textToSpeechContent[$key] = $message;
					foreach($message as $key2 => $send){
						if($key2 == "html"){
							$textToSpeechContent[$key] = $send;
						}else{
							$textToSpeechContent[$key2] = $send;
						}
					}
				}
			}
		}

	}

	public static function texToSpeech($contenido, $path, $userId, $history)
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

		self::orderArray($contenido, $textToSpeechContent);

		foreach ($textToSpeechContent as $index => $message) {

			$host = 'polly.eu-west-3.amazonaws.com';
			$maxAttempts = 5;
			$attempt = 0;
			$resolved = false;

			$dnsRecords = dns_get_record($host, DNS_A);

			while ($attempt < $maxAttempts && !$resolved) {
				$dnsRecords = dns_get_record($host, DNS_A);

				if ($dnsRecords !== false && count($dnsRecords) > 0) {
					$resolved = true;
				} else {
					$attempt++;
					if ($attempt < $maxAttempts) {
						\Log::warning("Intento $attempt: No se pudo resolver el host: $host. Reintentando en 20 segundos...");
						sleep(20); // Esperar 20 segundos antes de intentar nuevamente
					}
				}
			}

			if ($resolved) {
				sleep(5);
				\Log::info("Generando audio -> " . $posX);
				$history->status = "Generando audio " . $posX;
				$history->save();

				foreach ($providers as $provider) {

					$send = $index . " " . $message;
					$segmentos = self::splitTextWithSense($send);


					$audioStoragePath = $audioStoragePathMain . $posX++ . "/";

					//				\Log::info($segmentos);

					if (!File::exists($audioStoragePath)) {
						File::makeDirectory($audioStoragePath, $mode = 0777, true, true);
					}

					$union = "";

					foreach($segmentos as $segmento){

						$maxRetries = 5; // Máximo número de reintentos
						$retryDelay = 30; // Tiempo de espera en segundos antes de reintentar
						$attempt = 0; // Contador de intentos

						while ($attempt < $maxRetries) {
							try {
								if(!$segmento || $segmento == "."){
									break;
								}
								\Log::info("Generando audio -> " . $segmento);
								$result = TextToSpeech::dispatch($audioStoragePath, $segmento, $provider, $pos++);
								break; // Si el llamado es exitoso, salimos del bucle
							} catch (Exception $e) {

								\Log::info('INTENTO ' . $attempt . ' HA FALLADO AL LLAMAR A POLLY -> ' . $e->getMessage());

								$attempt++;
								if ($attempt >= $maxRetries) {
									\Log::info('HA FALLADO VARIAS VECES AL LLAMAR A POLLY - TERMINAMOS CON ESTE ERROR ' . $e->getMessage());
									// Si alcanzamos el número máximo de reintentos, lanzamos la excepción o manejamos el error
									throw $e;
								}
								// Esperamos antes de reintentar
								sleep($retryDelay);
							}
						}


						$results['audios'][$provider][] = $result;
						$union .= $audioStoragePath . $result['audio'] . "|";
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
			}
//continue;

		}
//		die("fernando");

		$finalFileName = "final.mp3";
		$cmd = "ffmpeg -i \"concat:$unionFinal\" -acodec copy " . $audioStoragePathMain . $finalFileName;
		shell_exec($cmd);
	}

}
