<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\UserStore;
use App\Http\Requests\Core\UserUpdate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->has('filter'), function($query) use ($request) {
            return $query->where(function ($q) use($request) {
                $q->where('name', 'like', "%{$request->filter}%")->orWhere('email', 'like', "%{$request->filter}%");
            });
        })->with('role')->orderBy('name')->paginate(5);

        return view('core.users.index', compact('users'));
    }

    public function create()
    {
        return view('core.users.create');
    }

    public function store(UserStore $request)
    {
        $user = User::create($request->only('name', 'email', 'password', 'role_id'));

        return $user;
    }

    public function edit(User $user)
    {
        return view('core.users.edit', compact('user'));
    }

    public function update(UserUpdate $request, User $user)
    {
        $user->update($request->only('name', 'email', 'password', 'role_id'));

        return redirect('core/users');
    }
}
