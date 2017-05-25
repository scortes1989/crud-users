<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //todos los usuarios de 1 rol
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
