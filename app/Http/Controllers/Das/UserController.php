<?php

namespace App\Http\Controllers\Das;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request('query'), fn ($query, $searchQuery) =>
                $query->where('name', 'like', "%{$searchQuery}%")
            )->latest()
            ->paginate(\setting(('pagination_limit')));

        return $users;
    }

    public function store()
    {

        // validate
        $validated =request()->validate(User::rules());


       return User::create([

            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],

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

        return response()->json(['success' => true], 200);
    }

    public function changeRole(User $user)
    {
        $user->update([
            'role' => request('role'),
        ]);

        return response()->json(['success' => true]);
    }

    public function bulkDelete()
    {
        User::whereIn('id', request('ids'))->delete();

        return response()->json(['message' => 'Users deleted successfully!']);
    }
}
