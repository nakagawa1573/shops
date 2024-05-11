<?php

namespace App\Rules;

use App\Models\Genre;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CsvGenreFields implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $genre = Genre::where('genre', $value)->first();
        if (is_null($genre)) {
            $fail('正しいジャンルを入力してください');
        }
    }
}
