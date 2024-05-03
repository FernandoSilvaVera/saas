<?php

namespace App;

use Aws\Polly\PollyClient;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use GuzzleHttp\Client;

class TextToSpeech
{
    public static function dispatch($session_id, $message, $provider, $index)
    {
        $result = [
            'message' => $message,
            'audio' => null
        ];
        $audio = "{$index}_{$provider}.mp3";
        switch ($provider) {
            case 'amazon':
                $client = new PollyClient([
                    'version' => 'latest',
                    'region' => env('AWS_DEFAULT_REGION'),
                    'credentials' => [
                        'key' => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);

                $response = $client->synthesizeSpeech([
                    'Text' => $message,
                    'OutputFormat' => 'mp3',
                    'VoiceId' => 'Lucia',
                ]);
                $result['audio'] = $audio;
                file_put_contents(env('AUDIO_STORAGE_PATH') . $session_id . '/' . $audio, $response['AudioStream']);
                break;
            case 'google':
                $textToSpeechClient = new TextToSpeechClient();
                $input = new SynthesisInput();
                $input->setText($message);
                $voice = new VoiceSelectionParams();
                $voice->setLanguageCode('es-ES');
                $audioConfig = new AudioConfig();
                $audioConfig->setAudioEncoding(AudioEncoding::MP3);
                $response = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
                $result['audio'] = $audio;
                file_put_contents(env('AUDIO_STORAGE_PATH') . $session_id . '/' . $audio, $response->getAudioContent());
                break;
            case 'openai':
                $client = new Client();
                $response = $client->post('https://api.openai.com/v1/audio/speech', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'model' => 'tts-1',
                        'input' => $message,
                        'voice' => 'alloy',
                    ]
                ]);
                $audioContent = $response->getBody()->getContents();
                $result['audio'] = $audio;
                file_put_contents(env('AUDIO_STORAGE_PATH') . $session_id . '/' . $audio, $audioContent);
                break;
        }
        return $result;
    }
}
