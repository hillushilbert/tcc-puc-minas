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
            //
            'customer' => 'required',
            'customer.name' => 'required|max:255',
            'customer.email' => 'required|max:255',
            'customer.cpf' => 'required|max:11',
            'origin_adress' => 'required',
            'origin_adress.zipcode' => 'required|max:8',
            'origin_adress.number' => 'required|int',
            'destination_adress' => 'required',
            'destination_adress.zipcode' => 'required|max:8',
            'destination_adress.number' => 'required|int',
            'supplier' => 'required',
            'supplier.name' => 'required|max:255',
            'unity' => 'required:max:100',
        ];
    }
}
