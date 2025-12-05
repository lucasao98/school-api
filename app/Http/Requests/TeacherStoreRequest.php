<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherStoreRequest extends FormRequest
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
            'cpf' => 'required|string|size:11|unique:teachers,cpf',
            'birthday' => 'required', Rule::date()->format('Y-m-d'),
            'background' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
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
            'password.required' => 'Password is required',
            'cpf.unique' => 'Cpf already exists',
            'cpf.size' => 'Cpf must have size 11',
            'cpf.required' => 'Cpf is required',
            'birthday.required' => 'Birthday is required',
            'birthday.date' => 'Birthday must have a date',
            'background.required' => 'Background is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists'
        ];
    }
}
