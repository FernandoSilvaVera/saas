<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TemplatePutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo_path' => 'sometimes|string',
            'favicon_path' => 'sometimes|string',
            'template_name' => 'sometimes|string',
            'css_left' => 'sometimes|string',
            'css_right' => 'sometimes|string',
            'css_top' => 'sometimes|string',
            'css_icons' => 'sometimes|string',
            'typography' => 'sometimes|string',
            'font_size' => 'sometimes|string'
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
