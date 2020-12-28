<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $appends = ['risk_score', 'risk_level'];

    protected $fillable = ['status', 'description', 'offer_id', 'email', 'phone', 'key'];

    public $risk_score = null;
    public $risk_level = null;
    
    public function getRiskLevelAttribute($value)
    {
        return $this->risk_level;
    }

    public function getRiskScoreAttribute($value)
    {
        return $this->risk_score;
    }

    public function User()
    {
        return $this->hasOne('App\User');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer')->withTrashed();
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
