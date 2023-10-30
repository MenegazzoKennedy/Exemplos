<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'visitas';

    protected $hidden = [
        'created_at','updated_at'
    ]; 
    public function feedback(){
        return $this->hasMany('App\Models\Feedback');
    }

    public function produto(){
        return $this->hasMany('App\Models\Produto', 'id','produto_id');
    }

    public function cliente(){
        return $this->hasMany('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function corretor(){
        return $this->hasMany('App\Models\Corretor', 'id', 'corretor_id');
    }
}
