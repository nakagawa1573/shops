<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class CsvImgFields implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $imgData = Http::get($value);
            if ($imgData->successful()) {
                if ($imgData->header('Content-Type') !== 'image/jpeg' && $imgData->header('Content-Type') !== 'image/png') {
                    $fail('jpegかpngの画像を選択してください');
                }
            } else {
                $fail('画像の取得に失敗しました');
            }
        } else {
            $fail('正しいURLを記述してください');
        }
    }
}
