<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function  index(){
        return User::latest()->get();
    }


    public function store(Request $request )
    {

        $request->validate(User::rules());
        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
    }

    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }

    public function destory(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public  function changeRole(user $user){

        $user->update([
            'role'=>request('role')
        ]);
        return response()->json(['success', true]);


    }

}
