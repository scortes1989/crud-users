<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Core\TraitUserScope;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, TraitUserScope;

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

    //functions
    public function isAdmin(): bool
    {
        return $this->role_id == 1;
    }

    public function regenerateToken()
    {
        $this->update([
            'api_token' => str_random(100)
        ]);
    }

}
