<?php

namespace App\Http\Controllers\WEB\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.profile', ['user' => $user]);
    }
}
