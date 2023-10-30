<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $hidden = [
        'created_at','updated_at'
    ];    

    protected $appends = [
        'image',
        'imageSemCaminho'
    ];

    public function getImageSemCaminhoAttribute() {
        return $this->attributes['image'];
    }
    public function getImageAttribute() {
        return url("storage/".$this->attributes['image']);
    }
}
