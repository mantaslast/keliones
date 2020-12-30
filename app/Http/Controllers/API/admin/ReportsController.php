<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Offer;
use App\Order;
use App\User;

class ReportsController extends Controller
{
    public function getData(Request $request)
    {
        
        $from = $request->data['from']. ' 00:00:00';
        $to = $request->data['to']. ' 23:59:59';
        $reports = $request->data['reports'];

        $returnData = [];
        foreach($reports as $reportType) {
            switch ($reportType) {
                case 'users':
                    $returnData['users'] = $this->getUsersData($from, $to);
                    break;
                case 'orders':
                    $returnData['orders'] = $this->getOrdersData($from, $to);
                    break;
                case 'offers':
                    $returnData['offers'] = $this->getOffersData($from, $to);
                    break;
            }
        }

        return json_encode(['success' => true, 'data' => $returnData, 'from' => $from, 'to' => $to]);
    }

    private function getUsersData($from, $to) {
        
        $users_counts = DB::table('users')
        ->select(
        DB::raw('COUNT(*) as total'),
        DB::raw('CAST(IFNULL(SUM(case when role = 1 then 1 else 0 end), 0) as UNSIGNED) as clients'),
        DB::raw('CAST(IFNULL(SUM(case when role = 2 then 1 else 0 end), 0) as UNSIGNED) as admin'),
        DB::raw('CAST(IFNULL(SUM(case when role = 3 then 1 else 0 end), 0) as UNSIGNED) as superadmin')
        )
        ->whereBetween('users.created_at', [$from, $to])
        ->first();

        return [
            'visi' => $users_counts->total,
            'klientai' => $users_counts->clients,
            'administratoriai' => $users_counts->admin,
            'super_administratoriai' => $users_counts->superadmin,
        ];
    }
    private function getOrdersData($from, $to) {
        $userscount = count(User::whereBetween('created_at', [$from, $to])->get());

        $orders = DB::table('orders')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->join('offers', 'offers.id', '=', 'orders.offer_id')
        ->select(
            DB::raw('COUNT(orders.id) as total_sales_count'),
            DB::raw('CAST(IFNULL(SUM(case when users.id IS NULL then 1 else 0 end), 0) as UNSIGNED) as nonregistered'),
            DB::raw('CAST(IFNULL(SUM(case when users.id IS NOT NULL then 1 else 0 end), 0) as UNSIGNED) as registered'),
            DB::raw('IFNULL(SUM(offers.price), 0) as total_sales'), 
            DB::raw('IFNULL(AVG(offers.price), 0) as total_sales_average')
            )
        ->whereBetween('orders.created_at', [$from, $to])
        ->first();

        $orders_counts = DB::table('orders')
        ->join('offers', 'offers.id', '=', 'orders.offer_id')
        ->where('orders.status', '=', 2)
        ->whereBetween('orders.created_at', [$from, $to])
        ->select(DB::raw('IFNULL(SUM(offers.price), 0) as successfull_total_sales'), DB::raw('COUNT(*) as successfull_sales_count'), DB::raw('IFNULL(AVG(offers.price), 0) as successfull_sales_average'))->first();

        return [
            'visi' => $orders->total_sales_count,
            'registruotu_vartotoju_uzsakymai' => $orders->nonregistered,
            'neregistruotu_vartotoju_uzsakymai' => $orders->registered,
            'santykis_uzsakymai_vartotojai' => ($orders->total_sales_count > 0 && $userscount > 0) ? round($orders->total_sales_count / $userscount,2) : '-',
            'visu_uzsakymu_suma' => round($orders->total_sales, 2),
            'visu_uzsakymu_vidurkis' => round($orders->total_sales_average, 2),
            'visi_apmoketi_uzsakymai' => $orders_counts->successfull_sales_count,
            'visu_apmoketu_uzsakymu_suma' => round($orders_counts->successfull_total_sales, 2),
            'visu_apmoketu_uzsakymu_vidurkis' => round($orders_counts->successfull_sales_average, 2),
            'santykis_apmoketi_uzsakymai_vartotojai' => ($orders_counts->successfull_sales_count > 0 && $userscount > 0) ? round($orders_counts->successfull_sales_count / $userscount,2) : '-',
            'santykis_uzsakymai_apmoketi_uzsakymai' => ($orders->total_sales_count > 0 && $orders_counts->successfull_sales_count > 0) ? round($orders->total_sales_count / $orders_counts->successfull_sales_count,2) : '-',
        ];
    }
    private function getOffersData($from, $to) {
        $offers = DB::table('offers')
        ->whereBetween('offers.created_at', [$from, $to])
        ->select(
            DB::raw('CAST(IFNULL(SUM(case when imported = 1 then 1 else 0 end), 0) as UNSIGNED) as imported'),
            DB::raw('CAST(IFNULL(SUM(case when hidden = 1 then 1 else 0 end), 0) as UNSIGNED) as hidden'),
            DB::raw('CAST(IFNULL(COUNT(*), 0) as UNSIGNED) as total_count'),
            DB::raw('IFNULL(MAX(price), 0) as most_expensive'),
            DB::raw('IFNULL(MIN(price), 0) as cheapest'),
            DB::raw('IFNULL(AVG(price), 0) as price_average'),
            DB::raw('IFNULL(AVG(discount), 0) as discount_average')
        )->first();

        $orderedCounts = DB::table('offers')
        ->join('orders', 'orders.offer_id', '=', 'offers.id')
        ->whereBetween('offers.created_at', [$from, $to])
        ->select(
            DB::raw('COUNT(orders.id) as total_orders'),
            DB::raw('orders.offer_id')
        )->groupBy(DB::raw('orders.offer_id'))
        ->get();
        
        $archivedOffers = count(Offer::whereBetween('offers.created_at', [$from, $to])->onlyTrashed()->get());

        return [
            'viso' => $offers->total_count,
            'brangiausias' => $offers->most_expensive,
            'pigiausias' => $offers->cheapest,
            'kainos_vidurkis' => round($offers->price_average, 2),
            'nuolaidos_vidurkis' => round($offers->discount_average, 2),
            'importuoti' => $offers->imported,
            'importuotu_sarase' => $offers->hidden,
            'archyvuoti' => $archivedOffers,
            'daugiausiai_uzsakytas' => $orderedCounts->max('total_orders') ?? 0,
            'maziausiai_uzsakytas' => $orderedCounts->min('total_orders') ?? 0,
        ];
    }
}
