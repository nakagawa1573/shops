<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
            'shop' => ['required', 'string', 'max:191'],
            'area_id' => ['required', 'numeric', 'between:1,47'],
            'genre_id' => ['required', 'array', 'max:3'],
            'genre_id.*' => ['numeric', 'between:1,5'],
            'overview' => ['required', 'max:200'],
            'img' => ['image', 'max:5000'],
        ];
    }

    public function messages()
    {
        return [
            'shop.required' => '店名を入力してください',
            'shop.string' => '店名を文字列で入力してください',
            'shop.max' => '店名は191文字以内で入力してください',
            'area_id.required' => 'エリアを選択してください',
            'area_id.numeric' => 'エリアを選択してください',
            'area_id.between' => 'エリアを選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'genre_id.array' => 'ジャンルを選択してください',
            'genre_id.max' => 'ジャンルは3個まで選択できます',
            'genre_id.*.numeric' => 'ジャンルを選択してください',
            'genre_id.*.between' => 'ジャンルを選択してください',
            'overview.required' => '店舗概要を入力してください',
            'overview.max' => '店舗概要は200文字以内で入力してください',
            'img.image' => '画像ファイルを選択してください',
            'img.max' => '5MB以下の画像を選択してください',
        ];
    }
}
