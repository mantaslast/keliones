<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function getData(Request $request)
    {
        dd($request->from);
        return json_encode($request->reports);
    }
}
