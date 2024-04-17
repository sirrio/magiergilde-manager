<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property integer $duration
 * @property integer $character_id
 * @property mixed $start_date
 * @property mixed $has_additional_bubble
 * @property mixed $notes
 */
class StoreAdventureRequest extends FormRequest
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
            'duration' => 'required|integer',
            'character_id' => 'required|integer',
            'start_date' => 'required|date',
            'has_additional_bubble' => 'required|boolean',
            'notes' => 'nullable|string',
        ];
    }
}
