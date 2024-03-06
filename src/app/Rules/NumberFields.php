<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumberFields implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value)) {
            if ($value < 1 || 9 < $value) {
                $fail('予約手続きに失敗しました');
            }
        } elseif ($value !== 'over_10') {
            $fail('予約手続きに失敗しました');
        }
    }
}
