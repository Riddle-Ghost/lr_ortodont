<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
            'name'          => 'string',
            'email'         => 'email|unique:users,email',
            'phone'         => 'string',
            'position'      => 'string',
            'birthday'      => 'date',
            'description'   => 'string',
            'photo'         => 'nullable|image'
        ];
    }
}
