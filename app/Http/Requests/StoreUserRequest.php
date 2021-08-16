<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|min:5|max:255',
            'last_name' => 'required|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            "first_name.required" => "Please add First Name",
            "first_name.min" => "The First Name has to have at least :min characters.",
            "first_name.max" => "The First Name has to have no more than :max characters.",
            "last_name.required" => "Please add Last Name",
            "last_name.min" => "The Last Name has to have at least :min characters.",
            "last_name.max" => "The Last Name has to have no more than :max characters.",
            "email.required" => "Please add email",
            "email.email" => "Please add a valid email",
            "email.unique" => "The email is already used.",
            "password.required" => "Please add password",
            "password.min" => "The First Name has to have at least :min characters.",
            "password.max" => "The First Name has to have no more than :max characters.",
        ];
    }

    /**
     * Custom response when validation fail
     *
     * @param Validator $validator
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['success' => 0, 'errors' => $errors])
        );
    }

}
