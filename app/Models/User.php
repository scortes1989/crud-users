<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id',
    ];

    protected $appends = [
        'edit_url',
    ];

    //relations
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //accesors
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getEditUrlAttribute()
    {
        return url('core/users/'.$this->id.'/edit');
    }


    //mutators
    public function setPasswordAttribute($value)
    {
        if($value != '') {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    //functions
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

}
