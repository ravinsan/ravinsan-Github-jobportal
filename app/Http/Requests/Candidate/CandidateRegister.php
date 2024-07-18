<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CandidateRegister extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'mobile'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => 'Enter Your Mobile Number',
            'mobile.numeric'  => 'Enter Only Numeric Value',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => false,
            'message'   => 'Validation errors',
            'error'      => $validator->errors()->first()
        ]));

    }
}
