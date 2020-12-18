<?php

namespace App\Http\Controllers\WEB\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Order;

class PaymentsController extends Controller
{
    public function get()
    {

    }

    public function pay(Request $request)
    {
        $order = Order::findOrFail($request->orderid);
        $amount = $order->offer->price * 100;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => "EUR",
                "source" => $request->stripeToken,
                "description" => "Užsakymas Travel, raktas: " . $order->key 
        ]);
        
        $order->status = 2;
        $order->save();

        Session::flash('success', 'Apmokėjimas pavyko!');
          
        return back();
    }
}
