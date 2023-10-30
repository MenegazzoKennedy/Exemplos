<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'regioes';

    protected $hidden = [
        'created_at','updated_at'
    ]; 

    public function cidade()
    {
        return $this->belongsTo('App\Models\Cidade');
    }
}
