<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TemplatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo_path' => 'required|string',
            'favicon_path' => 'required|string',
            'template_name' => 'required|string',
            'css_left' => 'required|string',
            'css_right' => 'required|string',
            'css_top' => 'required|string',
            'css_icons' => 'required|string',
            'typography' => 'required|string',
            'font_size' => 'required|string'
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
