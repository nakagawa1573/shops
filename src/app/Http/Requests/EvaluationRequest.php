<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
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
            'evaluation' => ['required','between:1,5'],
            'comment' => ['nullable', 'max:400'],
            'img' => ['nullable','mimes:image/jpeg,image/png', 'max:5000'],
        ];
    }

    public function messages()
    {
        return [
            'evaluation.required' => '評価の数を指定してください',
            'evaluation.between' => '投稿に失敗しました',
            'comment.max' => 'コメントは400文字以内で投稿してください',
            'img.mimetypes' => '画像はjpegかpngを選択してください',
            'img.max' => '5MB以下の画像を選択してください',
        ];
    }
}
