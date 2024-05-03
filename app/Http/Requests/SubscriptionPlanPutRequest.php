<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscriptionPlanPutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'word_limit' => 'sometimes|integer',
            'test_questions_count' => 'sometimes|integer',
            'summaries' => 'sometimes|integer',
            'voiceover' => 'sometimes|boolean',
            'editors_count' => 'sometimes|integer',
            'monthly_price' => 'sometimes|numeric',
            'annual_price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
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
