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
            'evaluation' => ['required', 'numeric','between:1,5'],
            'comment' => ['required', 'string', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
            'evaluation.required' => '★の数を指定してください',
            'evaluation.numeric' => '投稿に失敗しました',
            'evaluation.between' => '投稿に失敗しました',
            'comment.required' => 'コメントを入力してください',
            'comment.string' => '投稿に失敗しました',
            'comment.max' => 'コメントは200文字以内で投稿してください',
        ];
    }
}
