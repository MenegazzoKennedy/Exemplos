<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagUser extends Model
{
    use HasFactory;

    protected $table = "tag_user";
    
    protected $fillable = [];

    protected $hidden = [
        'created_at','updated_at'
    ]; 
    
}
