<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
		'email' => 'required|email|string',
		'name' => 'required|string',
		'password' => 'required|string',
		'confirmPassword' => 'required|string',
		'description' => 'string',
		'city' => 'string',
		'state' => 'string',
		'country' => 'required|string'
        ];
    } 

    protected function failedValidation(Validator $validator)
    {
    	throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
