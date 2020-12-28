<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use PDF;

class OrdersController extends Controller
{
    public function generatePdf(Request $request)
    {
        $orders = $request->orders;
        array_shift($orders);
        view()->share('admin.orders.pdf',$orders);
        $pdf = PDF::loadView('admin.orders.pdf', compact('orders'));

        return $pdf->stream('pdf_file.pdf');
    }

    public function generateInvoice(Request $request)
    {
        $orderId = $request->orderid;
        $order = Order::with('offer')->findOrFail($orderId);
        view()->share('shop.invoice',$order);
        $pdf = PDF::loadView('shop.invoice', compact('order'));

        return $pdf->download('pdf_file.pdf');
    }
}
