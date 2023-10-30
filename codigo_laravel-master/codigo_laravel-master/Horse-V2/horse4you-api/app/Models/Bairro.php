<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function cidade()
    {
        return $this->belongsTo('App\Models\Cidade');
    }
    public function corretores(){
        return $this->belongsToMany('App\Models\User');
    }
}
