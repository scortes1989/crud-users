<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //atributos que no seran guardados por asignacion masiva, lo contrario es usar $fillable
    protected $guarded = [];

    //atributos que no se mostraran en la respuesta
    protected $hidden = [
        'password', 'remember_token',
    ];

    //añadir accesores a la respuesta
    protected $appends = [
        'edit_url',
        'is_admin',
    ];

    //relations
    //el rol de 1 usuario
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function files()
    {
        return $this->morphOne(File::class, 'fileable');
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

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }


    //mutators
    public function setPasswordAttribute($value)
    {
        if($value != '') {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    //scopes
    public function scopeFilter($query, Request $request)
    {
        return $query->when($request->has('filter'), function($newQuery) use ($request) {
            return $newQuery->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->filter}%")->orWhere('email', 'like', "%{$request->filter}%");
            });
        });
    }

    public function scopeWithRole($query, $roleId)
    {
        return $query->with(['role' => function($query) use ($roleId) {
            return $query->where('id', $roleId);
        }]);
    }

    //functions
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

}
