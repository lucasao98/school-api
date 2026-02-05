<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'surname' => 'required|string',
            'birthday' => 'required', Rule::date()->format('Y-m-d'),
            'parent_email' => 'required|email|unique:students,parent_email',
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
            'name.required' => 'Name is required',
            'surname.required' => 'Surname is required',
            'birthday.required' => 'Birthday is required',
            'birthday.date' => 'Birthday must have a date',
            'parent_email.required' => 'Parent email is required',
            'parent_email.unique' => 'Parent email already exists'
        ];
    }
}
