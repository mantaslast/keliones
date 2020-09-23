<?php

namespace App\Http\Controllers\WEB\superAdmin\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;
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

        $user->email = $validated['email'];
        $user->name = $validated['name'];
        $user->role = $validated['role'];
        $user->address = $validated['address'];
        $user->phone = $validated['phone'];
        $user->country = $validated['country'];

        $user->save();

        return redirect()->back()->withSuccess('Sėkmingai išsaugota!');
    }
}