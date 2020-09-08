<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile as Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // $profile = new Profile([
        //     'phone' => '1',
        //     'country' => '2',
        //     'address' => '3',
        //     'user_id' => 4
        //     ]);
        //     $user = Auth::user();
        // $user->profile()->save($profile);
        // //dd($profile);
        return view('user.profile');
    }

    public function get()
    {
        $user = Auth::user();
        return json_encode(['wow' => $user]);
    }

    public function update(Request $req)
    {
        return json_encode(['wow' => $req]);
    }
}
