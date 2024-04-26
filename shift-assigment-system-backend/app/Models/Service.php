<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'rol_id'];

    public function role()
    {
        return $this->belongsTo(Rol::class);
    }
}
