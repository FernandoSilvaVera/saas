<?php

namespace App\Ia;

use Aws\Polly\PollyClient;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use GuzzleHttp\Client;

class OpenAI
{

	public function __construct($wordJson, $downloadPath, $userId, $scormZip, $history)
	{
		$this->jsonArray = json_decode($wordJson, true);
		
		$wordJson = json_encode($this->jsonArray);

		$this->apiKey = env('OPENAI_API_KEY');
		$this->assistant = new Assistants();
		$this->wordJson = $wordJson;
		$this->downloadPath = $downloadPath;
		$this->userId = $userId;

		$this->scormZip = $scormZip;

		$this->history = $history;
	}

	public function summary($summaryHTML, $scorm, $language="es-ES")
	{
		$generated = false;
		$send = "";
		$textoNuevo = "";
		$countTxtTotal = 0;

		$assistantId = env('ASST_SUMMARY');

		foreach($this->jsonArray as $title => $content){
			$send .= $title . " -> " . $content;
			$countTxt = strlen($send);
			$countTxtTotal += $countTxt;
			if($countTxtTotal > 4000){
				$message = "Dame un resumen extenso de esto en formato json de esto tambien quiero que me lo formatees en html" . $send;
				$response = $this->assistant->execute($message, $assistantId, "summary ", null);

				if(!$response){
					\Log::info("NO HA PODIDO GENERAR EL RESUMEN");
					return false;
				}

				if (isset($response->data[0]->content[0]->text->value)) {
					$data = $response->data[0]->content[0]->text->value;

					$data = json_decode($data, true);

					if(isset($data['resumen'])){
						$titulo = $data['resumen']['titulo'];
						$contenido = $data['resumen']['contenido'];


						$textoNuevo .= "<h1>$titulo</h1>";
						$textoNuevo .= "<p>$contenido</p>";

					}else{
						\Log::info("NO HAY NODO DE RESUMEN 1");
						break;
					}

				}else{
					\Log::info("EL RESUMEN ESTA DANDO UNA RESPUESTA QUE NO ESPERO 1");
					break;
				}

				$send = "";
			}
		}

		if($countTxtTotal <= 4000){
				$message = "Dame un resumen extenso de esto en formato json de esto tambien quiero que me lo formatees en html" . $send;
				$response = $this->assistant->execute($message, $assistantId, "summary2 ", null);

				if(!$response){
					\Log::info("NO HA PODIDO GENERAR EL RESUMEN");
					return false;
				}

				if (isset($response->data[0]->content[0]->text->value)) {
					$data = $response->data[0]->content[0]->text->value;

					\Log::info("RESUMEN" . $data);

					$data = json_decode($data, true);

					if(isset($data['resumen'])){
						$titulo = $data['resumen']['titulo'];
						$contenido = $data['resumen']['contenido'];


						$textoNuevo .= "<h1>$titulo</h1>";
						$textoNuevo .= "<p>$contenido</p>";


					}else{
						\Log::info("NO HAY NODO DE RESUMEN 1");
						return false;
					}

				}else{
					\Log::info("EL RESUMEN ESTA DANDO UNA RESPUESTA QUE NO ESPERO 2");
					return false;
				}

		}



		if($textoNuevo){
			$placeholder = '{summary}';
			$file = file_get_contents($summaryHTML);
			$file = str_replace($placeholder, $textoNuevo, $file);
			file_put_contents($summaryHTML, $file);

			$summaryHTMLScorm = $this->downloadPath  . "/scorm/" . $scorm;
			$scormFile = file_get_contents($summaryHTMLScorm);
			$scormFile = str_replace($placeholder, $textoNuevo, $scormFile);
			file_put_contents($summaryHTMLScorm, $scormFile);

			return true;
		}
			
		return false;

	}

	public function conceptualMap($conceptualMapHTML, $scorm, $language="es-ES")
	{
		$generated = false;
		$send = "";
		$textoNuevo = "";
		$countTxtTotal = 0;

		$assistantId = env('ASST_CONCEPTUAL_MAP');

		\Log::info('DENTRO DE CONCEPTUAL MAP');

		foreach($this->jsonArray as $title => $content){
			\Log::info('VA A INICIAR EL BUCLE DE CONCEPTUAL MAP');
			$send .= $title . " -> " . $content;
			$countTxt = strlen($send);
			$countTxtTotal += $countTxt;
			if($countTxtTotal > 4000){
				\Log::info('ES GRANDE SE TIENE QUE HACER EN SEGMENTOS');
				$message = "Crea un mapa conceptual de esto " . $send;

				$response = $this->assistant->execute($message, $assistantId, "conceptualMap", null);

				if(!$response){
					\Log::info("NO HA PODIDO GENERAR EL MAPA CONCEPTUAL");
					return false;
				}

				$data = null;

				if (isset($response->data[0]->content[0]->text->value)) {
					$data = $response->data[0]->content[0]->text->value;

					$first_line = strtok($data, "\n");
					$wrapped_first_line = wordwrap($first_line, 25, "<br>");
					$data = str_replace($first_line, $wrapped_first_line, $data);

/*
					$lines = explode("\n", $data);
					foreach ($lines as &$line) {
						$line = wordwrap($line, 25, "<br>");
					}
					$data = implode("\n", $lines);
*/

					$file = file_get_contents($conceptualMapHTML);

					$placeholder = '{markmapReplace}';
					$textoNuevo = $data;

					$file = str_replace($placeholder, $textoNuevo, $file);
					$file = str_replace("espacioContenido col l9 m12 s12", "col l9 m12 s12", $file);

					file_put_contents($conceptualMapHTML, $file);

					$conceptualMapHTMLScorm = $this->downloadPath  . "/scorm/" . $scorm;

					$scormFile = file_get_contents($conceptualMapHTMLScorm);
					$scormFile = str_replace($placeholder, $textoNuevo, $scormFile);
					$scormFile = str_replace("espacioContenido col l9 m12 s12", "col l9 m12 s12", $scormFile);
					file_put_contents($conceptualMapHTMLScorm, $scormFile);

					return true;
				}else{
					\Log::info("EL MAPA ME ESTA DANDO UNA RESPUETA QUE NO ESPERO 1");
					break;
				}
			}
		}

		if($countTxtTotal){
			\Log::info('ES PEQUEÑO NO HACE FALTA HACER SEGMENTOS');
			$message = "Crea un mapa conceptual de esto " . $this->wordJson;
			$response = $this->assistant->execute($message, $assistantId, "conceptualMap2 ",null);

			if(!$response){
				\Log::info("NO HA PODIDO GENERAR EL MAPA CONCEPTUAL");
				return false;
			}

			$data = null;

			if (isset($response->data[0]->content[0]->text->value)) {
				$data = $response->data[0]->content[0]->text->value;
				$file = file_get_contents($conceptualMapHTML);

				$placeholder = '{markmapReplace}';
				$textoNuevo = $data;

				$file = str_replace($placeholder, $textoNuevo, $file);
				$file = str_replace("espacioContenido col l9 m12 s12", "col l9 m12 s12", $file);

				file_put_contents($conceptualMapHTML, $file);

				$conceptualMapHTMLScorm = $this->downloadPath  . "/scorm/" . $scorm;
				$scormFile = file_get_contents($conceptualMapHTMLScorm);
				$scormFile = str_replace($placeholder, $textoNuevo, $scormFile);
				$scormFile = str_replace("espacioContenido col l9 m12 s12", "col l9 m12 s12", $scormFile);
				file_put_contents($conceptualMapHTMLScorm, $scormFile);

				return true;
			}else{
				\Log::info("EL MAPA ME ESTA DANDO UNA RESPUETA QUE NO ESPERO 2");
			}

		}

		return false;
	}

	public function parseQuestions(){

	}

	public function questions($questionsHTML, $numQuestions, $scorm=null, $language="es-ES")
	{

		$generated = false;
		$send = "";
		$textoNuevo = "";
		$countTxtTotal = 0;

		$assistantId = env('ASST_QUESTIONS');

		foreach($this->jsonArray as $title => $content){
			$send .= $title . " -> " . $content;
			$countTxt = strlen($send);
			$countTxtTotal += $countTxt;
			if($countTxtTotal > 4000){

				$message = "Crea $numQuestions preguntas en formato json sobre esto " . $send;
				$response = $this->assistant->execute($message, $assistantId, "questions", null);

				if(!$response){
					\Log::info("NO HA PODIDO GENERAR LAS PREGUNTAS");
					return false;
				}

				if (isset($response->data[0]->content[0]->text->value)) {
					$data = $response->data[0]->content[0]->text->value;
					$data = json_decode($data, true);

					$file = file_get_contents($questionsHTML);

					$placeholder = "{questions}";

					$textoNuevo = "";

					$aiken = "";

					if(isset($data['preguntas']) && isset($data['preguntas'][0]['pregunta'])){

						foreach($data['preguntas'] as $question){

							if(!isset($question['pregunta'])){
								continue;
							}

							$textoNuevo .= '
								<script>

								function mantenerElementosAleatorios(del) {
									var questions = document.querySelectorAll(\'.questions\');

									var numToKeep = 4;

									if (questions.length > numToKeep) {

										var indices = [];
										for (var i = 0; i < questions.length; i++) {
											indices.push(i);
										}

										for (var i = indices.length - 1; i > 0; i--) {
											var j = Math.floor(Math.random() * (i + 1));
											var temp = indices[i];
											indices[i] = indices[j];
											indices[j] = temp;
										}

										for (var i = 0; i < questions.length; i++) {
											if (indices.indexOf(i) > numToKeep - 1) {
												if(del){
													var parentElement = questions[i].parentNode;
													parentElement.removeChild(questions[i]);
												}else{
													questions[i].style.display = \'none\';
												}
											}
										}

									}



								}

							function mostrar(){
								var questions = document.querySelectorAll(\'.questions\');

								questions.forEach(function(element) {
										element.style.display = \'block\';
										});
							}


							window.addEventListener(\'load\', function() {
									cargarBotonPaginaTest();
									});

							document.addEventListener("DOMContentLoaded", function() {
									mantenerElementosAleatorios();
									mostrar();
									mantenerElementosAleatorios(true);
									});

							</script>
								';

							$textoNuevo .= "<div class='questions'>";
							$textoNuevo.= "<h4>" . $question['pregunta'] . "</h4>";

							$letraInicial = 'A';

							$aiken .= $question['pregunta'] . "\n";
							$ANSWER = "";

							foreach($question['respuestas'] as $key => $respuesta){

								$aiken .= $letraInicial . ") " . $respuesta . "\n";

								if($respuesta == $question['correcta']){
									$ANSWER = $letraInicial;
									$textoNuevo .= "<input type='checkbox' class='opcion_correcta' id='opcion_correcta$respuesta$key' name='opcion' value='" . $respuesta . "'/>".
										"<label for='opcion_correcta$respuesta$key'>" . $respuesta . "</label><br>";
								}else{
									$textoNuevo .= "<input type='checkbox' class='opcion_incorrecta' id='opcion$respuesta$key' name='opcion' value='" . $respuesta . "'/>" . 
										"<label for='opcion$respuesta$key'>" . $respuesta . "</label><br>";
								}

								$letraInicial++;

							}

							$aiken .= "ANSWER: " . $ANSWER . "\n\n";

							$textoNuevo .= "</div>";

						}

						$file = str_replace($placeholder, $textoNuevo, $file);
						file_put_contents($questionsHTML, $file);
						file_put_contents($this->downloadPath. "/preguntas.aiken", $aiken);

						if($scorm){
							$questionsHTMLScorm = $this->downloadPath  . "/scorm/" . $scorm;
							$scormFile = file_get_contents($questionsHTMLScorm);
							$scormFile = str_replace($placeholder, $textoNuevo, $scormFile);
							file_put_contents($questionsHTMLScorm, $scormFile);
						}


						return true;

					}

				}else{
					\Log::info("LAS PREGUNTAS ME ESTAN DANDO UN FORMATO QUE NO ESPERO 1");
					break;
				}

				$send = "";
			}

			if($countTxtTotal <= 4000){

				$maxQuestions = $numQuestions;

				$allQuestions['preguntas'] = [];

				$questionsCount = 0;

				while($questionsCount < $maxQuestions){
					\Log::info("Inicio de generar preguntas -> " . $questionsCount);
					\Log::info($questionsCount);

					$message = "Crea 15 preguntas en formato json sobre esto " . $send;
					$response = $this->assistant->execute($message, $assistantId, "questions2", null);

					if(!$response){
						\Log::info("NO HA PODIDO GENERAR LAS PREGUNTAS");
						return false;
					}

					if (isset($response->data[0]->content[0]->text->value)) {

						\Log::info("Procesando las preguntas ");

						$data = $response->data[0]->content[0]->text->value;
						$data = json_decode($data, true);

						$file = file_get_contents($questionsHTML);

						$placeholder = "{questions}";

						$textoNuevo = "";

						$aiken = "";

						if(isset($data['preguntas']) && isset($data['preguntas'][0]['pregunta'])){
							foreach($data['preguntas'] as $question){
								if($questionsCount < $maxQuestions){
									$allQuestions['preguntas'][] = $question;
									$questionsCount++;
								}
							}
						}
					}

				}

				if(isset($allQuestions['preguntas']) && isset($allQuestions['preguntas'][0]['pregunta'])){

					foreach($allQuestions['preguntas'] as $question){

						if(!isset($question['pregunta'])){
							continue;
						}

						$textoNuevo .= '
							<script>

							function mantenerElementosAleatorios(del) {
								var questions = document.querySelectorAll(\'.questions\');

								var numToKeep = 4;

								if (questions.length > numToKeep) {

									var indices = [];
									for (var i = 0; i < questions.length; i++) {
										indices.push(i);
									}

									for (var i = indices.length - 1; i > 0; i--) {
										var j = Math.floor(Math.random() * (i + 1));
										var temp = indices[i];
										indices[i] = indices[j];
										indices[j] = temp;
									}

									for (var i = 0; i < questions.length; i++) {
										if (indices.indexOf(i) > numToKeep - 1) {
											if(del){
												var parentElement = questions[i].parentNode;
												parentElement.removeChild(questions[i]);
											}else{
												questions[i].style.display = \'none\';
											}
										}
									}

								}



							}

						function mostrar(){
							var questions = document.querySelectorAll(\'.questions\');

							questions.forEach(function(element) {
									element.style.display = \'block\';
									});
						}


						window.addEventListener(\'load\', function() {
								cargarBotonPaginaTest();
								});

						document.addEventListener("DOMContentLoaded", function() {
								mantenerElementosAleatorios();
								mostrar();
								mantenerElementosAleatorios(true);
								});

						</script>
							';

						$textoNuevo .= "<div class='questions'>";
						$textoNuevo.= "<h4>" . $question['pregunta'] . "</h4>";

						$letraInicial = 'A';

						$aiken .= $question['pregunta'] . "\n";
						$ANSWER = "";

						foreach($question['respuestas'] as $key => $respuesta){

							$aiken .= $letraInicial . ") " . $respuesta . "\n";

							if($respuesta == $question['correcta']){
								$ANSWER = $letraInicial;
								$textoNuevo .= "<input type='checkbox' class='opcion_correcta' id='opcion_correcta$respuesta$key' name='opcion' value='" . $respuesta . "'/>".
									"<label for='opcion_correcta$respuesta$key'>" . $respuesta . "</label><br>";
							}else{
								$textoNuevo .= "<input type='checkbox' class='opcion_incorrecta' id='opcion$respuesta$key' name='opcion' value='" . $respuesta . "'/>" . 
									"<label for='opcion$respuesta$key'>" . $respuesta . "</label><br>";
							}

							$letraInicial++;

						}

						$aiken .= "ANSWER: " . $ANSWER . "\n\n";

						$textoNuevo .= "</div>";

					}

					$file = str_replace($placeholder, $textoNuevo, $file);
					file_put_contents($questionsHTML, $file);
					file_put_contents($this->downloadPath. "/preguntas.aiken", $aiken);

					if($scorm){
						$questionsHTMLScorm = $this->downloadPath  . "/scorm/" . $scorm;
						$scormFile = file_get_contents($questionsHTMLScorm);
						$scormFile = str_replace($placeholder, $textoNuevo, $scormFile);
						file_put_contents($questionsHTMLScorm, $scormFile);
					}

					return true;

				}

				$send = "";

			}

		}

		return false;

	}

	public function openScorm()
	{
		// Esto es un zip
		$scormZip = $this->scormZip;
		// Extraerlo en esta ruta
		$downloadPath = $this->downloadPath;

		// Obtener el nombre del archivo zip sin la extensión
		$zipFileName = pathinfo($scormZip, PATHINFO_FILENAME);
		// Crear la ruta completa donde se extraerá el contenido
		$extractPath = $downloadPath . '/' . $zipFileName;

		// Crear una instancia de ZipArchive
		$zip = new \ZipArchive;

		// Abrir el archivo zip
		if ($zip->open($scormZip) === TRUE) {
			// Extraer el contenido en la ruta especificada
			$zip->extractTo($extractPath);
			$zip->close();
		} else {
			echo "No se pudo abrir el archivo zip.\n";
		}
	}



	public function closeScorm()
	{
		$scormZip = $this->scormZip;
		$downloadPath = $this->downloadPath;

		$zipFileName = pathinfo($scormZip, PATHINFO_FILENAME);
		$extractPath = $downloadPath . '/' . $zipFileName;

		$newZipPath = $scormZip;

		if (file_exists($newZipPath)) {
			unlink($newZipPath);
		}

		$command = "cd " . escapeshellarg($downloadPath) . " && zip -r " . escapeshellarg($newZipPath) . " " . escapeshellarg($zipFileName);

		$output = null;
		$resultCode = null;
		exec($command, $output, $resultCode);
	}


}
