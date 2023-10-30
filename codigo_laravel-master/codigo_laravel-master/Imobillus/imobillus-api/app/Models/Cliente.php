<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 
    public function users(){
        return $this->belongsTo('App\Models\User', 'corretor_id_preferido');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function visitas(){
        return $this->hasMany('App\Models\Visita');
    }
    protected $appends = [
        'url'
    ];
    
    public function getUrlAttribute() {
        return url($this->attributes['url_foto']);
    }
}
