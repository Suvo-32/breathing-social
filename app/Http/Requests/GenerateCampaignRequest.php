<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateCampaignRequest extends FormRequest
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
            'brief' => ['required', 'string', 'min:3', 'max:1000'],
            'language' => ['nullable', 'string', 'in:bilingual,bengali,english'],
            'tone' => ['nullable', 'string', 'max:100'],
            'image_mode' => ['nullable', 'string', 'in:unified,distinct'],
            'actor' => ['nullable', 'string', 'max:100'],
            'publish_date' => ['nullable', 'string', 'max:100'],
            'scheduled_at' => ['nullable', 'date'],
            'instagram_scheduled_at' => ['nullable', 'date'],
            'youtube_scheduled_at' => ['nullable', 'date'],
            'x_scheduled_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'brief.required' => 'Please provide a campaign brief (e.g. "Byomkesh S9, dark & mysterious, from 10 Oct").',
            'brief.min' => 'The campaign brief should be at least 3 characters.',
        ];
    }
}
