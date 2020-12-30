<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class EditProfile extends FormRequest
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
            'phone' => ['string','regex:/(86|\+3706)\d{7,7}$/'],
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Neteisingas telefono numeris',
            'phone.string' => 'Neteisingas telefono numerio formatas',
        ];
    }
}
