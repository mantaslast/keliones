<?php

namespace App\Http\Controllers\WEB\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $orders_counts = DB::table('orders')
        ->join('offers', 'offers.id', '=', 'orders.offer_id')
        ->whereIn('orders.status', [2, 3])
        ->select(DB::raw('SUM(offers.price) as total_sales'), DB::raw('COUNT(*) as sales_count'), DB::raw('AVG(offers.price) as sales_average'))->first();
       
        $now = date('Y-m-d H:i:s',strtotime('now'));
        $tocheck = date('Y-m-d H:i:s',strtotime('now -3day'));
        
        $users_counts = DB::table('users')
        ->select(DB::raw('CAST(SUM(DATE(users.created_at) BETWEEN "'.$tocheck.'" AND "'.$now.'") as UNSIGNED) as new_users'), DB::raw('COUNT(*) as total_users'))
        ->first();

        $users = DB::table('users')
        ->select(DB::raw('COUNT(*) as count'), DB::raw(' substring(created_at,1,10) as date'))
        ->groupBy(DB::raw('substring(created_at,1,10)'))
        ->get();

        $successfullOrders = DB::table('orders')
        ->select(DB::raw('COUNT(*) as count'), DB::raw(' substring(created_at,1,10) as date'))
        ->whereIn('status', [2,3])
        ->groupBy(DB::raw('substring(created_at,1,10)'))
        ->get();

        $unsuccessfullOrders = DB::table('orders')
        ->select(DB::raw('COUNT(*) as count'), DB::raw(' substring(created_at,1,10) as date'))
        ->whereIn('status', [0,1])
        ->groupBy(DB::raw('substring(created_at,1,10)'))
        ->get();
        $return = array(
            'users_counts' => $users_counts,
            'orders_counts' => $orders_counts,
            'users' => $users,
            'orders' => [
                'successfull' => $successfullOrders,
                'unsuccessfull' => $unsuccessfullOrders,
            ],
        );
        
        return view('admin.index', ['data' => $return]);
    }
}
