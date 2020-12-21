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
}
