<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [];
    
    protected $hidden = [
        'created_at','updated_at','url_modelo'
    ];

    protected $appends = [
        'documento'
    ];

    public function getDocumentoAttribute() {
        return url("storage/files/".$this->attributes['documento']);
    }

    public function negociacao(){
        return $this->belongsToMany('App\Models\Negociacao', 'documentos_negociacao', 'documentos_id', 'negociacao_id')->withTimestamps();
    }
}
