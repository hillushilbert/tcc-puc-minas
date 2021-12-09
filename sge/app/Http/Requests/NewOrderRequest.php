<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderRequest extends FormRequest
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
            'origin' => 'required',
            'origin.number' => 'required|int',
            'destiny' => 'required',
            'destiny.number' => 'required|int',
            'unity' => 'required:max:100',
        ];
    }
}
