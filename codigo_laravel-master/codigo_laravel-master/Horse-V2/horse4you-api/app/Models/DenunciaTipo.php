<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenunciaTipo extends Model
{
    use HasFactory;
    protected $table = 'denuncia_tipo';

    protected $hidden = [
        'created_at','updated_at'
    ]; 
}
