<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'survey_id' => ['required', 'exists:surveys,id'],
            'question_text' => ['required', 'string'],
            'question_type' => ['required', Rule::in(['likert', 'text', 'multiple_choice'])],
            'likert_scale_id' => ['nullable', 'required_if:question_type,likert', 'exists:likert_scales,id'],
            'is_required' => ['boolean'],
            'order' => ['required', 'integer', 'min:0'],
        ];
    }
}
