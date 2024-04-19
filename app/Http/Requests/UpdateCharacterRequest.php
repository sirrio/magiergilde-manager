<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $class
 * @property mixed $external_link
 * @property mixed $name
 */
class UpdateCharacterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => 'required|string',
          'class' => 'required|exists:character_classes,id',
          'external_link' => 'required|url',
          'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }
}
