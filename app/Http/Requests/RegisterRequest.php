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
            'password' => 'required|confirmed'
        ];
    }

    /**
     * Allow error messages for api requests
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => 422,
                'success' => false,
                'message' => 'Please fill in all required fields',
                'errors' => $validator->errors()
            ]
        , 422));
    }
}
