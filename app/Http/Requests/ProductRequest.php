<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images' => 'max:4',
            'images.*' => 'image|mimes:jpeg,bmp,jpg,png|between:1, 5000',
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
