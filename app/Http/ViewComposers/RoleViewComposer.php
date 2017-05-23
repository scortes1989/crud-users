<?php

namespace App\Http\ViewComposers;

use App\Models\Role;
use Illuminate\View\View;

class RoleViewComposer
{

    public function compose(View $view)
    {
        $view->with('roles', Role::orderBy('name')->pluck('name', 'id'));
    }
}