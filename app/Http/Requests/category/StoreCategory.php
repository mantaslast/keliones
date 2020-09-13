<?php

namespace App\Http\Requests\category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
            'name' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Neteisingas pavadinimo formatas',
            'name.required' => 'Privaloma įvesti kategorijos pavadinimą'
        ];
    }
}
