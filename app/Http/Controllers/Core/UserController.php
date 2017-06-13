<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\UserStore;
use App\Http\Requests\Core\UserUpdate;
use App\Mail\CreatedUser;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        //filtro con scopes, en el modelo user esta la logica
        //$users = User::filter($request)->withRole(1)->orderBy('name')->paginate(5);


        //with('relation') soluciona el problema de n + 1 (n queries por 1 registro)
        $users = $this->user->with('role')->orderBy('name')->get();

        return $users->groupBy('role_id');

        
        return view('core.users.index', compact('users'));
    }

    public function create()
    {
        return view('core.users.create');
    }

    public function store(UserStore $request)
    {
        //usando transacciones de BD
        //DB::transaction(function() use($request) {
            $user = User::create($request->only('name', 'email', 'password', 'role_id', 'birthday'));

            /*if($request->hasFile('photo')) {
                $path = $request->photo->store('photos', 'public');

                $user->files()->create([
                    'path' => $path,
                ]);
            }*/

            Mail::to($user->email)->send(new CreatedUser($user));

            return redirect('core/users');
        //});
    }

    public function edit(User $user)
    {
        //descargar un archivo e indicar nombre de archivo al descargar
        //return response()->download(storage_path('app/public/'.$user->files->path), 'photo1.jpg');

        return view('core.users.edit', compact('user'));
    }

    public function update(UserUpdate $request, User $user)
    {
        $user->update($request->only('name', 'email', 'password', 'role_id'));

        return redirect('core/users');
    }
}
