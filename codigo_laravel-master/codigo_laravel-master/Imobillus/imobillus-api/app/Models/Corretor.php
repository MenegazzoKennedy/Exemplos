<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corretor extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 

    protected $appends = [
        'url'
    ];
    
    public function getUrlAttribute() {
        return url($this->attributes['url_foto']);
    }

    protected $table = 'corretores';

    public function users(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function bairros(){
        return $this->belongsToMany('App\Models\Bairro')->withTimestamps();
    }
    public function regioes(){
        return $this->belongsToMany('App\Models\Regiao')->withTimestamps();
    }
    public function visitas(){
        return $this->hasMany('App\Models\Visita')->withTimestamps();
    }
    
}
