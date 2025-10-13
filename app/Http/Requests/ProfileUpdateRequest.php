<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'nullable',
                'lowercase',
                'email',
                'unique:users,email',
                ...$this->isPrecognitive() || app()->isLocal() ? [] : ['indisposable'],
            ],
        ];
    }
}
