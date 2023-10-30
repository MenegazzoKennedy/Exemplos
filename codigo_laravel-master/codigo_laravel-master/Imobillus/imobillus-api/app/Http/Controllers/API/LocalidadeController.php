<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Bairro;
use App\Models\Regiao;

class LocalidadeController extends Controller
{
    public function consultaEstados()
    {
        $estados = Estado::all();
        return response()->json($estados,200);

    }
    public function consultaCidades($id)
    {
        $cidades = Estado::with('cidades')->where('id', $id)->get();
        if(isset($cidades[0])){
            return response()->json($cidades,200);
        }else{
            return response()->json(["errors" => 'Não existe estado cadastrado com esse id'], 404);
        }
    }
    public function consultaLocaisBairrosCidades($id_cidade)
    {
        $bairros = Cidade::with(['bairros', 'regioes'])->where('id', $id_cidade)->get();
        if(isset($bairros[0])){
            return response()->json($bairros,200);
        }else{
            return response()->json(["errors" => 'Não existe cidades cadastrada com esse id'], 404);
        }
    }
}
