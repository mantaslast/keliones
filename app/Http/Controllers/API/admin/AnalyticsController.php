<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function get () {
        $from = $_GET['from'];
        $to = $_GET['to'];
        
        $orders_counts = DB::table('orders')
        ->join('offers', 'offers.id', '=', 'orders.offer_id')
        ->whereBetween('orders.created_at', [$from, $to])
        ->whereIn('orders.status', [2, 3])
        ->select(DB::raw('IFNULL(SUM(offers.price), 0) as total_sales'), DB::raw('COUNT(*) as sales_count'), DB::raw('IFNULL(AVG(offers.price), 0) as sales_average'))->first();
       
        $now = date('Y-m-d H:i:s',strtotime('now'));
        $tocheck = date('Y-m-d H:i:s',strtotime('now -3day'));
        
        $users_counts = DB::table('users')
        ->select(DB::raw('CAST(IFNULL(SUM(DATE(users.created_at) BETWEEN "'.$tocheck.'" AND "'.$now.'"), 0) as UNSIGNED) as new_users'), DB::raw('COUNT(*) as total_users'))
        ->whereBetween('users.created_at', [$from, $to])
        ->first();

        $users = DB::table('users')
        ->select(DB::raw('substring(created_at,1,10) as date'), DB::raw('COUNT(*) as count'))
        ->whereBetween('users.created_at', [$from, $to])
        ->groupBy(DB::raw('substring(created_at,1,10)'))
        ->get();

        $successfullOrders = DB::table('orders')
        ->select(DB::raw(' substring(created_at,1,10) as date'), DB::raw('COUNT(*) as count'))
        ->whereBetween('orders.created_at', [$from, $to])
        ->whereIn('status', [2,3])
        ->groupBy(DB::raw('substring(created_at,1,10)'))
        ->get();

        $unsuccessfullOrders = DB::table('orders')
        ->select(DB::raw(' substring(created_at,1,10) as date'), DB::raw('COUNT(*) as count'))
        ->whereBetween('orders.created_at', [$from, $to])
        ->whereIn('status', [1,0])
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
        
        return json_encode(['data' => $return]);
    }
}
