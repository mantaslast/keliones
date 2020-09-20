<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $fillable = ['name', 'leave_at', 'arrive_at', 'price', 'discount', 'description', 'country', 'city', 'images'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
