<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Auth;
use App\Http\Requests\profile\EditProfile as EditProfileRequest;


class ProfileController extends Controller
{
    public function index()
    {
        return new UserResource(Auth::user());
    }

    public function update(EditProfileRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return new UserResource(Auth::user());
    }
}
