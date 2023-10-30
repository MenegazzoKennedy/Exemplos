<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
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
        return url($this->attributes['url_midia']);
    }
}
