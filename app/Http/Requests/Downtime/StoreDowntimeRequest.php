<?php

namespace App\Http\Requests\Downtime;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $duration
 * @property mixed $character_id
 * @property mixed $start_date
 * @property mixed $notes
 */
class StoreDowntimeRequest extends FormRequest
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
            //
        ];
    }
}