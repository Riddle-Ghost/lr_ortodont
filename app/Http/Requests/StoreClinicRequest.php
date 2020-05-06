<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
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
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string',
            'legal_name'    => 'required|string',
            'address'       => 'required|string',
            'legal_address' => 'required|string',
            'requisites'    => 'required|string',
            'photo'         => 'nullable|image'
        ];
    }
}
