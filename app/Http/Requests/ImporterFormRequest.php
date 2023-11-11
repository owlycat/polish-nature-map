<?php

namespace App\Http\Requests;

use App\Rules\ExistingImporterClassRule;
use Illuminate\Foundation\Http\FormRequest;

class ImporterFormRequest extends FormRequest
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
            'importers' => ['required', 'array', 'min:1'],
            'importers.*.name' => 'required|string',
            'importers.*.class' => ['required', 'string', new ExistingImporterClassRule],
        ];
    }
}
