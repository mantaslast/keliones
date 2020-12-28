<?php

namespace App\Http\Controllers\WEB\superadmin\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\Http\Requests\orders\StoreOrder;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $charges = $stripe->charges->all()->data;
        $transacionKeyArray = [];
        foreach($charges as $charge) {
            $splitDescription = explode(' ', $charge->description);
            $transactionKey = '';
            if (count($splitDescription) > 3) {
                $dataArr = array(
                    'key' => $splitDescription[3],
                    'risk_score' => $charge->outcome->risk_score,
                    'risk_level' => $charge->outcome->risk_level,
                );
                $transacionKeyArray[$splitDescription[3]] = $dataArr;
            }
        }

        $orders = Order::with('offer')->get();
        foreach ($orders as $key => $order) {
            if (array_key_exists($order->key, $transacionKeyArray)){
                $orders[$key]->risk_score = $transacionKeyArray[$order->key]['risk_score'];
                $orders[$key]->risk_level = $transacionKeyArray[$order->key]['risk_level'];
            }
        }
        
        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.order', ['order' => $order]);
    }

    public function update(StoreOrder $request, Order $order)
    {
        $validated = $request->validated();
        $order->admin_id = Auth::user()->id;
        $order->update($validated);
        return redirect()->back()->withSuccess('Sėkmingai atnaujintas pasiūlymas!'); 
    }
}
