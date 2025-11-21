<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLikertScaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'min_value' => ['sometimes', 'required', 'integer'],
            'max_value' => ['sometimes', 'required', 'integer', 'gt:min_value'],
            'min_label' => ['sometimes', 'required', 'string', 'max:100'],
            'max_label' => ['sometimes', 'required', 'string', 'max:100'],
        ];
    }
}
