<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status', 'description', 'offer_id', 'email', 'phone', 'key'];

    public function User()
    {
        return $this->hasOne('App\User');
    }

    public function Offer()
    {
        return $this->hasOne('App\Offer');
    }

    public function Admin()
    {
        return $this->hasOne('App\User');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Inicijuotas';
                break;
            case 1:
                return 'Atšauktas';
                break;
            case 2:
                return 'Apmokėtas';
                break;
            case 3:
                return 'Įvykęs';
                break;
        }
    }
}
