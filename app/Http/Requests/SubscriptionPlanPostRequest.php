<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscriptionPlanPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'test_questions_count' => 'required|boolean',
            'summaries' => 'required|boolean',
            'voiceover' => 'required|boolean',
            'editors_count' => 'required|integer',
            'monthly_price' => 'required|numeric',
            'annual_price' => 'required|numeric',
            'description' => 'required|string'
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
