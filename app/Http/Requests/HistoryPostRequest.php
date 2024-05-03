<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HistoryPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'main_file_path' => 'required|string',
            'date' => 'required|date',
            'email' => 'required|email',
            'audio_path' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}
