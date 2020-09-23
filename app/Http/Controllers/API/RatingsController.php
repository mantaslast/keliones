<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Rating;

class RatingsController extends Controller
{
    public function setRating(Request $request)
    {
        $params = [
            'user_id' => Auth::user()->id,
            'offer_id' => $request->offer,
            'rating' => $request->rating
        ];

        if (Rating::where('user_id', '=', Auth::user()->id)->where('offer_id', '=', $request->offer)->count() >= 1) {
            $rating = Rating::where('user_id', '=', Auth::user()->id)->where('offer_id', '=', $request->offer)->first();
            $rating->update($params);
        } else {
            $rating = new Rating($params);
            $rating->save();
        }
       
        return json_encode(['success' => $rating]);
    }
}
