<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;
    
    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado');
    }
    public function bairros(){
        return $this->hasMany('App\Models\Bairro', 'cidade_id');
    }
    
    public function regioes(){
        return $this->hasMany('App\Models\Regiao', 'cidade_id');
    }
}
