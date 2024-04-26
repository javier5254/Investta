<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'location_id', 'rol_id'];

    protected $hidden = ['password', 'remember_token'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function role()
    {
        return $this->belongsTo(Rol::class);
    }
}
