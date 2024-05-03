<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\TextToSpeech;
use Faker\Provider\ar_EG\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextToSpeechController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('textToVoice')) {
            return response()->json(['message' => 'textToVoice is required'], 422);
        }
        $textToVoice = $request->textToVoice;
        if (!is_array($textToVoice)) {
            return response()->json(['message' => 'textToVoice must be an array'], 422);
        }
        if (sizeof($textToVoice) === 0) {
            return response()->json(['message' => 'textToVoice must not be empty'], 422);
        }
        $session_id = uniqid();
        if (!is_dir(env('AUDIO_STORAGE_PATH') . $session_id)) {
            mkdir(env('AUDIO_STORAGE_PATH') . $session_id, 0777, true);
        }
        $results = [
            'session_id' => $session_id,
            'session_path' => env('AUDIO_STORAGE_PATH') . $session_id,
            'audios' => [
                'amazon' => [],
                'google' => [],
                'openai' => []
            ],
            'combined_audios' => [
                'amazon' => [],
                'google' => [],
                'openai' => []
            ]
        ];
        $providers = ['amazon', 'google', 'openai'];
        foreach ($textToVoice as $index => $message) {
            foreach ($providers as $provider) {
                $result = TextToSpeech::dispatch($session_id, $message, $provider, $index);
                $results['audios'][$provider][] = $result;
            }
        }

        foreach ($providers as $provider) {
            $combined_audio = "{$provider}.mp3";
            $results['combined_audios'][$provider] = $combined_audio;
            $combined_audios = [];
            foreach ($results['audios'][$provider] as $audio) {
                $combined_audios[] = env('AUDIO_STORAGE_PATH') . $session_id . '/' . $audio['audio'];
            }
            $combined_audios = implode('|', $combined_audios);

            shell_exec("ffmpeg -i \"concat:$combined_audios\" -acodec copy " . env('AUDIO_STORAGE_PATH') . $session_id . '/' . "$provider.mp3");
        }

        History::create([
            'main_file_path' => env('AUDIO_STORAGE_PATH') . $session_id,
            'date' => now(),
            'email' => 'random@email.com',
            'audio_path' => env('AUDIO_STORAGE_PATH') . $session_id,
        ]);

        return response()->json($results);
    }
}
