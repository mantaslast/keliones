<?php

namespace App\Http\Controllers\WEB\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
   public function search(Request $request)
   {

        $query = DB::table('offers');
        
        if ($request->leave_at) {
            $query->whereDate('leave_at','>', $request->leave_at);
        }
        
        if ($request->arrive_at) {
            $query->whereDate('arrive_at','<', $request->arrive_at);
        }

        if ($request->text) {
            $query->where('name', 'like', '%'.$request->text.'%')
            ->orWhere('country', 'like', '%'.$request->text.'%')
            ->orWhere('city', 'like', '%'.$request->text.'%');     
        }
        if ($request->price) {
            $prices = explode(",", $request->price);
            $query->whereBetween('price', $prices);
        }
        if ($request->country) {
            $query->where('country', $request->country);
        }

        $offers = $query->paginate(20);

        return view('shop.search', ['offers' => $offers]);
   }
}
