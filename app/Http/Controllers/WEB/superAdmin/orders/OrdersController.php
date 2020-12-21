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
        $orders = Order::with('offer')->get();
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
