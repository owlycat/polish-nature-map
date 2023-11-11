<?php

namespace App\Rules;

use App\Importers\GeojsonFeaturesImporter;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistingImporterClassRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! class_exists($value) || ! is_subclass_of($value, GeojsonFeaturesImporter::class)) {
            $fail("The {$value} is not a valid importer class.");
        }
    }
}
