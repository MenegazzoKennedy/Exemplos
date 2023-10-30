<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacoes extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes';

    protected $fillable = [];

    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function cliente()
    {
        return $this->belongsToMany('App\Models\User', 'cliente_id_user');
    }
    public function corretor()
    {
        return $this->belongsToMany('App\Models\User', 'corretor_id_user');
    }
}
