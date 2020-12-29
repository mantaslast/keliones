<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;

class IndexController extends Controller
{
    public function index()
    {
        $offers = Offer::where('hidden', 0)->get();

        return view('shop.home', ['offers' => $offers]);
    }
}
