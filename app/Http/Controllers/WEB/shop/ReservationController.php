<?php

namespace App\Http\Controllers\Web\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use App\Http\Requests\reservation\StoreReservation;
use App\Order;
use Auth;
use Illuminate\Support\Str;
use Session;

class ReservationController extends Controller
{
    public function create(Offer $offer)
    {
        return view('shop.reservation', ['offer' => $offer]);
    }

    public function store(StoreReservation $request)
    {
        $validated = $request->validated();
        $offer = Offer::find($request->offer);
        $order = Order::create([
            'status' => 0,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'offer_id' => $request->offer,
            'description' => $offer->name . '; ' . $offer->country . '; ' . $offer->city . '; ' . $offer->price,
            'key' => Str::random(20),    
        ]);

        if (Auth::user()) {
            $order->user_id = Auth::user()->id;
        }

        $order->save();
        Session::put('order', $order);
        return redirect(route('reservation.success'));
    }

    public function success()
    {
        return view('shop.success', ['message' => 'Sėkmingai rezervuota kelionė!']);
    }
}