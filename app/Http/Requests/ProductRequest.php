<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $id = $this->product ? $this->product->id : $this->id;
        return [
            'product_name' => array('required', 'string', 'unique:product_table,product_name,'.$id),
            'product_description' => array('required', 'string'),
            'quantity' => array('required', 'numeric', 'integer', 'min:0'),
            'price' => array('required', 'numeric', 'min:0'),
            'status' => array('boolean')
        ];
    }
}
