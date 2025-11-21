<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikertScaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'min_value' => ['required', 'integer'],
            'max_value' => ['required', 'integer', 'gt:min_value'],
            'min_label' => ['required', 'string', 'max:100'],
            'max_label' => ['required', 'string', 'max:100'],
        ];
    }
}
