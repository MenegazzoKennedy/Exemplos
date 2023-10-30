<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $updated_at = false;
    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at'
    ];  
}
