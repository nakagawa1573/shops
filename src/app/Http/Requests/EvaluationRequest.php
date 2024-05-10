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
            'comment' => ['max:400'],
            'img' => ['nullable', 'mimetypes:image/jpeg,image/png'],
        ];
    }

    public function messages()
    {
        return [
            'evaluation.required' => '評価の数を指定してください',
            'evaluation.between' => '投稿に失敗しました',
            'comment.max' => 'コメントは400文字以内で投稿してください',
            'img.mimes' => '画像はjpegかpngを選択してください'
        ];
    }
}
