<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => array('required', 'string'),
            'last_name' => array('required', 'string'),
            'email_address' => array('required', 'email', 'unique:users_table'),
            'address' => array('required', 'string'),
            'mobile_number' => array('required', 'string', 'unique:users_table'),
            'status' => array('boolean')
        ];
    }
}
