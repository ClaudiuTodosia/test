<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTripRequest extends FormRequest
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
            'slug' => 'required|unique:trips|min:2|max:255',
            'title' => 'required|min:2|max:255',
            'description' => 'required',
            'start_date' => 'required|date_format:Y-m-d|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required',
            'price' => 'required|integer|min:1',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['success' => 0, 'errors' => $errors])
        );
    }

}
