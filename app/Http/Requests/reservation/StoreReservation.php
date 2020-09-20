<?php

namespace App\Http\Requests\reservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservation extends FormRequest
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
            'email' => ['email'],
            'phone' => ['string','regex:/(86|\+3706)\d{7,7}$/'],
        ];
    }
    
    public function messages()
    {
        return [
            'email.email' => 'Neteisingas el. pašto formatas',
            'phone.regex' => 'Neteisingas telefono numerio formatas',
            'phone.string' => 'Neteisingas telefono numerio formatas',
        ];
    }
}
