<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function produto(){
        return $this->belongsToMany('App\Models\Produto')->withTimestamps();
    }    
}
