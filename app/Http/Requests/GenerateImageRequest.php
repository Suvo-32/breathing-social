<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prompt' => ['required', 'string', 'min:2', 'max:2000'],
            'aspect_ratio' => ['nullable', 'string', 'in:1:1,16:9,9:16,4:3,3:4'],
            'api_key' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'prompt.required' => 'Please enter a prompt to generate an image.',
            'prompt.min' => 'Prompt must be at least 2 characters.',
        ];
    }
}
