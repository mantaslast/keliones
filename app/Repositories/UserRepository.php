<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    private $users;
    
    public function __construct () 
    {
        $this->users = new User();
    }

    public function all () 
    {
        return $this->users->all();
    }

    public function allByRole($role)
    {
        return $this->users->where('role',$role)->get();
    }

}
