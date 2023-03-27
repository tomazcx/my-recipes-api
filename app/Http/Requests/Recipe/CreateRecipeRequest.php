<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class CreateRecipeRequest extends FormRequest
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
		'name' => 'required|string',
		'image' => [
			'required',
			File::image()
		],
		'timeToPrepare' => 'required|string',
		'portions' => 'required|integer',
		'difficulty' => 'required|integer',
		'ingredients' => 'required|string',
		'stepsToPrepare' => 'required|string',
		'categories' => 'required|array',
		'categories.*' => 'integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
    	throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
