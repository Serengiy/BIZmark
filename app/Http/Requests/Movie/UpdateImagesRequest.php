<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImagesRequest extends FormRequest
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
        $rules = [
            'mainFile' => ['nullable','image'],
        ];

        for ($i = 0; $i <= 4; $i++) {
            $optionalFileKey = "optionalFile{$i}";
            if (request()->hasFile($optionalFileKey)) {
                $rules[$optionalFileKey] = ['image'];
            }
        }

        return $rules;
    }
}
