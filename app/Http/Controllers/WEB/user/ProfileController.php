<?php

namespace App\Http\Controllers\WEB\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Rating;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', '=', $user->id)->get();

        foreach($orders as $order) {
            $rating = Rating::where('user_id', '=', $user->id)->where('offer_id', '=', $order->offer->id)->first();
            if ($rating) {
                $order->offer->rating = $rating->rating;
            }
        }

        return view('user.profile', ['user' => $user, 'orders' => $orders]);
    }
}
