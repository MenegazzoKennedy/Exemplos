<?php

namespace App\Models;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Corretor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negociacao extends Model
{
    use HasFactory;

    protected $table = 'negociacao';

    public function nogocio()
    {
        return $this->hasManyThrough(Produto::class, Cliente::class, Corretor::class);
    }
    
    public function documentos_v1()
    {
        return $this->belongsToMany('App\Models\Documento', 'documentos_negociacao', 'negociacao_id', 'documentos_id');
    }

    public function documentos()
    {
        return $this->hasMany('App\Models\Documento', 'negociacao_id');
    }

    public function cliente(){
        return $this->hasMany('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function corretor(){
        return $this->hasMany('App\Models\Corretor', 'id', 'corretor_id');
    }

    public function imovel(){
        return $this->hasMany('App\Models\Produto', 'id', 'imovel_id');
    }

}
