<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'subject' => ['required', 'string', 'max:191'],
            'content' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return[
            'subject.required' => '主題を入力してください',
            'subject.string' => '主題は文字列で入力してください',
            'subject.max' => '主題は191文字以内で入力してください',
            'content.required' => '本文を入力してください',
            'content.string' => '本文は文字列で入力してください',
            'content.max' => '本文は500文字以内で入力してください',
        ];
    }
}
