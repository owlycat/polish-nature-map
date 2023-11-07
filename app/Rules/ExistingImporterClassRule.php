<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Importers\GeojsonFeaturesImporter;

class ExistingImporterClassRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!class_exists($value) || !is_subclass_of($value, GeojsonFeaturesImporter::class)) {
            $fail("The {$value} is not a valid importer class.");
        }
    }
}
