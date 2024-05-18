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

	public function __construct($wordJson, $downloadPath, $userId){

		$json = json_decode($wordJson, true);
		$wordJson = json_encode($json);

		$this->apiKey = env('OPENAI_API_KEY');
		$this->assistant = new Assistants();
		$this->wordJson = $wordJson;
		$this->downloadPath = $downloadPath;
		$this->userId = $userId;
	}

	public function summary($summaryHTML)
	{
		$message = "Dame un resumen extenso de esto en formato json de esto tambien quiero que me lo formatees en html" . $this->wordJson;
		$assistantId = "asst_vg9yWuWBqqWYQhO7OMlRQuxP";
		$response = $this->assistant->execute($message, $assistantId);

		if (isset($response->data[0]->content[0]->text->value)) {
			$data = $response->data[0]->content[0]->text->value;

			$data = json_decode($data, true);

			if(isset($data['resumen'])){

				$titulo = $data['resumen']['titulo'];
				$contenido = $data['resumen']['contenido'];

				$file = file_get_contents($summaryHTML);

				$placeholder = '{summary}';
				$textoNuevo = "<h1>$titulo</h1>";
				$textoNuevo .= "<p>$contenido</p>";

				$file = str_replace($placeholder, $textoNuevo, $file);
				file_put_contents($summaryHTML, $file);
				return true;
			}

		}

		return false;

	}

	public function conceptualMap($conceptualMapHTML)
	{
		$message = "Crea un mapa conceptual de esto " . $this->wordJson;
		$assistantId = "asst_4ESaXO8NoqzMXeIlnfC1NrPS";
		$response = $this->assistant->execute($message, $assistantId);

		$data = null;

		if (isset($response->data[0]->content[0]->text->value)) {
			$data = $response->data[0]->content[0]->text->value;
			$file = file_get_contents($conceptualMapHTML);

			$placeholder = '{markmapReplace}';
			$textoNuevo = $data;

			$file = str_replace($placeholder, $textoNuevo, $file);
			$file = str_replace("espacioContenido col l9 m12 s12", "col l9 m12 s12", $file);

			file_put_contents($conceptualMapHTML, $file);
			return true;
		}

		return false;

	}

	public function questions($questionsHTML, $numQuestions)
	{
		$message = "Crea $numQuestions preguntas en formato json sobre esto " . $this->wordJson;
		$assistantId = "asst_wCSbBD0KHXIIaKMKvubNj1CB";
		$response = $this->assistant->execute($message, $assistantId);

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

						$aiken .= $letraInicial++ . ") " . $respuesta . "\n";

						if($respuesta == $question['correcta']){
							$ANSWER = $letraInicial;
							$textoNuevo .= "<input type='checkbox' class='opcion_correcta' id='opcion_correcta$respuesta$key' name='opcion' value='" . $respuesta . "'/>".
								"<label for='opcion_correcta$respuesta$key'>" . $respuesta . "</label><br>";
						}else{
							$textoNuevo .= "<input type='checkbox' class='opcion_incorrecta' id='opcion$respuesta$key' name='opcion' value='" . $respuesta . "'/>" . 
								"<label for='opcion$respuesta$key'>" . $respuesta . "</label><br>";
						}

					}

					$aiken .= "ANSWER: " . $ANSWER . "\n\n";

					$textoNuevo .= "</div>";

				}

				$file = str_replace($placeholder, $textoNuevo, $file);
				file_put_contents($questionsHTML, $file);
				file_put_contents($this->downloadPath. "/preguntas.aiken", $aiken);

				return true;

			}



		}

		return false;

	}

}
