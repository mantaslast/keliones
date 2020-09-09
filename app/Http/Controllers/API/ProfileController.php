<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Auth;
use App\Profile;
use App\Http\Requests\profile\EditProfile as EditProfileRequest;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * returns view
     */
    public function index()
    {
        $id = Auth::user()->id;
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProfileRequest $request, $id)
    {
        $profile = Profile::find($id);
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->country = $request->country;
        $profile->save();

        return new UserResource(Auth::user());
    }
}
