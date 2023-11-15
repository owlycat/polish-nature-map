<?php

namespace App\Rules;

use App\Models\PersonalMap;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersonalMapNameNoDuplicatesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $personalMap = PersonalMap::where('name', $value)->first();

        if ($personalMap) {
            if ($personalMap->id === request()->input('personal_map_id')) {
                return;
            }

            $fail("The {$value} is already in use.");
        }
    }
}
