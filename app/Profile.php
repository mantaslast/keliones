<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = ['user_id', 'country', 'address', 'phone'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
