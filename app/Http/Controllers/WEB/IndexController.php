<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;

class IndexController extends Controller
{
    public function index()
    {
        $offers = Offer::all();

        return view('shop.home', ['offers' => $offers]);
    }
}
