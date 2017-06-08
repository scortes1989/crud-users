<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Requests\Core\UserStore;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('name')->when($request->has('all'), function ($query) {
            return $query->withTrashed();
        });

        $users = $request->has('paginate') ? $query->paginate($request->paginate) : $query->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'data' => $user->load('role'),
        ]);
    }

    public function store(UserStore $request)
    {
        $request->merge([
            'api_token' => str_random(100),
        ]);

        $user = User::create($request->only('name', 'email', 'password', 'role_id', 'api_token'));

        return response()->json([
            'data' => $user,
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only('name', 'email', 'password', 'role_id'));

        return response()->json([
            'data' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'data' => $user,
        ]);
    }
}
