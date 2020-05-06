<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'clinic_id'                             => 'required|integer|exists:clinic_infos,user_id',
            'payment_method'                        => 'required|integer',
            'payment_option'                        => 'required|integer',
            'patient_name'                          => 'required|string',
            'patient_surname'                       => 'required|string',
            'patient_patronymic'                    => 'required|string',
            'patient_sex'                           => 'required|boolean',
            'patient_birthday'                      => 'required|date',
            'patient_diagnosis'                     => 'required|string',
            'patient_photo_profile'                 => 'required|file',
            'patient_photo_fullface_smile'          => 'required|file',
            'patient_photo_fullface_without_smile'  => 'required|file',
            'patient_photo_occlusar_up'             => 'required|file',
            'patient_photo_occlusar_down'           => 'required|file',
            'patient_photo_lateral_left'            => 'required|file',
            'patient_photo_front'                   => 'required|file',
            'patient_photo_lateral_right'           => 'required|file',
            'recipe'                                => 'required|json'
        ];
    }
}
