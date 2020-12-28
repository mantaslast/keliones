<?php

namespace App\Http\Requests\offer;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffer extends FormRequest
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
            'country' => 'string|required',
            'city' => 'string|required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'leave_at' => 'required|date',
            'arrive_at' => 'required|date|after_or_equal:leave_at',
            'category_id' => 'required',
            'description' => 'required|string|min:10',
            'imgs' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Neteisingas pavadinimo formatas!',
            'name.required' => 'Pavadinimas privalomas!',
            'country.string' => 'Neteisingas šalies formatas!',
            'country.required' => 'Šalis privaloma!',
            'city.string' => 'Neteisingas miesto formatas!',
            'city.required' => 'Miestas privalomas!',
            'price.numeric' => 'Neteisingas kainos formatas!',
            'price.required' => 'Kaina privaloma!',
            'discount.numeric' => 'Neteisingas nuolaidos formatas!',
            'discount.required' => 'Nuolaida privaloma!',
            'leave_at.date' => 'Neteisingas išvykimo datos formatas!',
            'leave_at.required' => 'Išvykimo data privaloma!',
            'arrive_at.date' => 'Neteisingas atvykimo datos formatas!',
            'arrive_at.required' => 'Atvykimo data privaloma!',
            'arrive_at.after' => 'Atvykimo data negali būti ankstesnė negu išvykimo data!',
            'description.string' => 'Neteisingas aprašymo formatas!',
            'description.min' => 'Per trumpas aprašymas!',
            'description.required' => 'Aprašymas privalomas!',
            'category_id.required' => 'Kategorija privaloma!',
            'imgs.required' => 'Pasiūlymo nuotraukos yra privalomos!'
        ];
    }
}
