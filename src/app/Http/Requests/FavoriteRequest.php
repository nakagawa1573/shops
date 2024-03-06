<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'shop_id' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return[
            'user_id.required' => 'お気に入り登録に失敗しました',
            'user_id.numeric' => 'お気に入り登録に失敗しました',
            'shop_id.required' => 'お気に入り登録に失敗しました',
            'shop_id.numeric' => 'お気に入り登録に失敗しました',
        ];
    }
}
