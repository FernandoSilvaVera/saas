<?php

namespace App\Ia;

use Aws\Polly\PollyClient;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use GuzzleHttp\Client;

class Assistants
{

	public function __construct(){
		$this->apiKey = env('OPENAI_API_KEY');
	}


	public function createThread()
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $this->apiKey,
			'OpenAI-Beta: assistants=v2'
		));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		$return = json_decode($response);
		return $return;
	}

	public function addMessage($message)
	{
		$ch = curl_init();

		$body = json_encode([
			"role" => "user",
			"content" => $message
		]);

		curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads/' . $this->threadId . '/messages');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $this->apiKey,
			'OpenAI-Beta: assistants=v2'
		));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);


		$return = json_decode($response);

		return $return;
	}

	private function runs($assistantId)
	{

		$ch = curl_init();

		$requestData = array(
			'assistant_id' => $assistantId
		);
		$jsonData = json_encode($requestData);

		curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads/' . $this->threadId . '/runs');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $this->apiKey,
			'Content-Type: application/json',
			'OpenAI-Beta: assistants=v2'
		));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		$return = json_decode($response);

		return $return->id;
	}

	private function checkStatus($id)
	{

		$ch = curl_init();


		// Configura las opciones de cURL
		curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/threads/$this->threadId/runs/$id");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $this->apiKey,
			"OpenAI-Beta: assistants=v2"
		));

		// Ejecuta la sesión cURL
		$response = curl_exec($ch);

		// Cierra la sesión cURL
		curl_close($ch);

		// Verifica si hubo un error

		$return = json_decode($response);
		return $return;

	}

	private function messages()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/threads/' . $this->threadId . '/messages');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $this->apiKey,
					'OpenAI-Beta: assistants=v2'
					));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		$return = json_decode($response);

		return $return;
	}

	public function execute($message, $assistantId)
	{
		$this->thread = $this->createThread();
		$this->threadId = $this->thread->id;

		$this->addMessage($message);

		$runId = $this->runs($assistantId);

		$maxAttempts = 6; 
		$attempts = 0;

		do {
			$status = $this->checkStatus($runId);

			if ($status->status != "completed") {
				sleep(10); 
				$attempts++;
			}
		} while ($status->status != "completed" && $attempts < $maxAttempts);

		return $this->messages();

	}

}
