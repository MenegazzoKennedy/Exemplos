<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Produto extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 
    public function tipos(){
        return $this->belongsToMany('App\Models\Tipo')->withTimestamps();
    }
    public function categorias(){
        return $this->belongsToMany('App\Models\Tipo');
    }
    public function midias() {
        return $this->hasMany('App\Models\Midia');
    }
    public function caracteristicas() {
        return $this->hasMany('App\Models\Caracteristica');
    }
}
