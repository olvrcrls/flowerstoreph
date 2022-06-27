<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'price' => array('required', 'numeric', 'min:0'),
            'product_id' => array('required', 'numeric', 'exists:\App\Models\Product,id'),
            'user_id' => array('required', 'numeric', 'exists:\App\Models\User,id')
        ];
    }
}
