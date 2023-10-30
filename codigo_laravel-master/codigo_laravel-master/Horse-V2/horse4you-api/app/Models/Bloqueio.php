<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloqueio extends Model
{
    use HasFactory;

    public function usersBloqueados()
    {
        return $this->belongsToMany('App\Models\User', 'id', 'user_bloqueado', 'user_bloqueante');
    }
}
