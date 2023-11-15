<?php

namespace App\Http\Requests;

use App\Models\PersonalMap;
use App\Rules\PersonalMapNameNoDuplicatesRule;
use App\Rules\PersonalMapNoMeNameRule;
use App\Rules\SluggableRule;
use Illuminate\Foundation\Http\FormRequest;

class PersonalMapShareRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $personalMapId = $this->input('personal_map_id');
        $personalMap = PersonalMap::where('id', $personalMapId)->first();

        if ($user->id !== $personalMap->user_id) {
            return false;
        }

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
            'privacy.value' => ['required', 'string', 'in:public,private'],
            'name' => ['required', 'string', 'min:3', 'max:30', new PersonalMapNameNoDuplicatesRule(), new SluggableRule(), new PersonalMapNoMeNameRule()],
            'personal_map_id' => ['required', 'integer', 'exists:personal_maps,id'],
        ];
    }
}
