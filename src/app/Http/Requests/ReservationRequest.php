<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NumberFields;
use App\Rules\DateFields;

class ReservationRequest extends FormRequest
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
            'date' => ['required', 'date', new DateFields],
            'time' => ['required', 'date_format:H:i'],
            'number' => ['required', new NumberFields ],
        ];
    }

    public function messages()
    {
        return[
            'date.required' => '予約手続きに失敗しました',
            'date.date' => '予約手続きに失敗しました',
            'time.required' => '予約手続きに失敗しました',
            'time.date_format' => '予約手続きに失敗しました',
            'number.required' => '予約手続きに失敗しました',
        ];
    }
}
