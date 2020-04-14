<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function asignar()
    {
        $users = User::where('vigente', 'si')->get();
        return view('user.asignar')->with(compact('users'));
    }
}
