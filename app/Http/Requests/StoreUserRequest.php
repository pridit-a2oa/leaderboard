<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
                'required',
                'string',
                'lowercase',
                'email',
                ...$this->isPrecognitive() ? [] : ['indisposable'],
                Rule::unique(User::class),
            ],

            'password' => [
                'required',
                ...$this->isPrecognitive() ? [] : ['confirmed'],
                Password::defaults(),
            ],

            'conditions' => [
                'required',
                'accepted:true',
            ],
        ];
    }
}
