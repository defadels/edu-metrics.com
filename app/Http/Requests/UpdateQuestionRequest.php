<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'survey_id' => ['sometimes', 'required', 'exists:surveys,id'],
            'question_text' => ['sometimes', 'required', 'string'],
            'question_type' => ['sometimes', 'required', Rule::in(['likert', 'text', 'multiple_choice'])],
            'likert_scale_id' => ['nullable', 'required_if:question_type,likert', 'exists:likert_scales,id'],
            'is_required' => ['boolean'],
            'order' => ['sometimes', 'required', 'integer', 'min:0'],
        ];
    }
}
