<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $postCodePattern = "/^[A-Z]{1,2}[0-9][A-Z0-9]? \d[A-Z]{2}$/i";
        if (! preg_match($postCodePattern, $value)) {
            $fail('The post code field is not in the correct format');
        }
    }
}
