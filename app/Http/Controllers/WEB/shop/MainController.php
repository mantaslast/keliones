<?php

namespace App\Http\Controllers\WEB\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;


class MainController extends Controller
{
    public function index($slug, Request $request)
    {
        $offer = Offer::withTrashed()->findOrFail($request->offer);
        $trashed = 0;
        if ($offer->trashed()) {
            $trashed = 1;
        }

        return view('shop.deal', ['offer' => $offer, 'trashed' => $trashed]);
    }
}
