<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            'profile_url' => 'image|mimes:jpeg,bmp,jpg,png|between:1, 5000',
            'password' => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{8,}$/'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => 'Your password must be at least 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character(#?!@$%^&*-
_)',
        ];
    }

    /**
     * Allow error messages for api requests
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(errorResponse(422, 'Please fill in all required fields', $validator->errors()));
    }
}
