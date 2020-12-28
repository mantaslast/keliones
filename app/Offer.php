<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rating;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'leave_at', 'arrive_at', 'price', 'discount', 'description', 'country', 'city', 'images', 'hidden', 'imported'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function countRatings()
    {
        if (Rating::where('offer_id', '=', $this->id)->count() > 0) {
            $ratingsCount = Rating::where('offer_id', '=', $this->id)->count();
            $ratings = Rating::where('offer_id', '=', $this->id)->sum('rating');
            return round($ratings / $ratingsCount , 0); 
        } else {
            return 0;
        }
    }
}
