<?php

namespace App\Http\Controllers\WEB\superAdmin\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;
use App\Profile;
use  App\Http\Requests\user\EditUser;

class UserController extends Controller
{
    private $userRepository;

    public function __construct ()
    {
        $this->userRepository = new UserRepository();
    }
    
    public function index($role = null)
    {
        if ($role) {
            $users = $this->userRepository->allByRole($role);
        } else {
            $users = $this->userRepository->all();
        }

        return view('admin.users.users',['users' => $users]);
    }

    public function show(User $user)
    {
        return view('admin.users.user', ['user' => $user]);
    }

    public function destroy(User $user)
    {

        if ($user->profile) {
            $user->profile->delete();
        }
        
        $user->delete();

        return redirect()->back(); 
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user'=>$user]);
    }

    public function update(User $user, EditUser $request)
    {
        $validated = $request->validated();

        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        if ($user->profile) {
            $user->profile->phone = $request->phone;
            $user->profile->address = $request->address;
            $user->profile->country = $request->country;
            $user->profile->save();
        } else {
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->phone = $request->phone;
            $profile->address = $request->address;
            $profile->country = $request->country;
            $profile->save();
            $user->profile()->save($profile);
        }

        $user->save();

        return redirect()->back()->withSuccess('Sėkmingai išsaugota!');
    }
}