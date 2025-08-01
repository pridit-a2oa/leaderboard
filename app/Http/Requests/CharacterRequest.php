<?php

namespace App\Http\Requests;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Character::findOrFail($this->character_id)
            ->where(
                'id64',
                $this->user()->connections->firstWhere('name', 'steam')->pivot->identifier
            )
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'character_id' => ['required', 'exists:characters,id'],
        ];
    }
}
