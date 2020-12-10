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
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSuccessfull;
use Illuminate\Support\Facades\URL;
use App\Reminder;

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

        $reminder = Reminder::create([
            'email' => $order->email,
            'title' => 'Įvertinkite kelionę!',
            'body' => 'Norėtume sužinoti, ar Jums patiko kelionė! Jūsų įsigytų kelionių informaciją galite rasti savo profilio puslapyje, adresu: <a href="'.URL::to('/').'/profilis">'.URL::to('/').'/profilis</a>',
            'order_id' => $order->id,
            'send_at' => $offer->arrive_at,
        ]);

        $reminder->save();

        if (Auth::user()) {
            $order->user_id = Auth::user()->id;
        }

        $order->save();
        Session::put('order', $order);
        return redirect(route('reservation.success'));
    }

    public function show($key)
    {
        $order = Order::with('offer')->where('key', '=', $key)->first();

        return view('shop.order', ['order' => $order]);
    }

    public function success()
    {
        $order = Session::get('order');
        Mail::to($order->email)->send(new ReservationSuccessfull($order, route('reservation.show', ['order' => $order->key])));

        return view('shop.success', ['message' => 'Sėkmingai rezervuota kelionė!']);
    }
}