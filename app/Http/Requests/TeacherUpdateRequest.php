<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherUpdateRequest extends FormRequest
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
            'name' => 'string|nullable',
            'cpf' => 'string|size:11|nullable',
            'birthday' => 'nullable', Rule::date()->format('Y-m-d'),
            'background' => 'string|nullable'
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Name must be a string',
            'cpf.size' => 'Cpf must have size 11',
            'birthday.date' => 'Birthday must have a date',
            'background.string' => 'Background must be a string',
        ];
    }
}
