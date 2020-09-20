<?php

namespace App\Http\Controllers\WEB\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Offer;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $category = Category::where('slug', $slug)->first();
        
        return view('shop.category', ['category' => $category]);
    }
}
