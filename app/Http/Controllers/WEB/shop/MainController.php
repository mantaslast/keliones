<?php

namespace App\Http\Controllers\WEB\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;


class MainController extends Controller
{
    public function index($slug, Offer $offer)
    {   
        return view('shop.deal', ['offer' => $offer]);
    }
}
