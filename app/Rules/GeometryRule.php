<?php

namespace App\Rules;

use Closure;
use geoPHP;
use Illuminate\Contracts\Validation\ValidationRule;

class GeometryRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            geoPhp::load(json_encode($value), 'json');
        } catch (\Exception $e) {
            $fail($e->getMessage());
        }
    }
}
