<?php

namespace App\Http\Controllers\Api\Core;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();

        return response()->json([
            'data' => $roles,
        ]);
    }
}
