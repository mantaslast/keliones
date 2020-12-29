<?php

namespace App\Http\Controllers\WEB\admin\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function get()
    {
        return view('admin.reports.index');
    }
}
