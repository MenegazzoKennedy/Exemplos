<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    
    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function cidades(){
        return $this->hasMany('App\Models\Cidade', 'estados_id');
    }
}
