<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Negociacao;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Documento;
use App\Enums\TipoNegociacao;
use Auth;

class NegociacaoController extends Controller
{
    public function negociacao(Request $request){
        //Auth::user()->id
        
        $request->validate([
            'imovel_id' => 'required|integer',
            'corretor_id' => 'required|integer',
            'tipo_negociacao' => 'required|string',
            'files' => 'array',
        ]);
        $produto = Produto::find($request->imovel_id);
        if ($request->corretor_id) {
            $corretor = Corretor::find($request->corretor_id);
        }else{
            //revisar regra negociação
            $corretor = 1;
        }   
        
        //relacionamento é com usuario e nao com cliente
        $cliente = Cliente::where('user_id', Auth::user()->id)->get();
        $tipos = TipoNegociacao::getKeys();
        $tipoId = -1;
        foreach($tipos as $key => $tipo){
            if($tipo == $request->tipo_negociacao){
                $tipoId = $key;
            }
        }
        if(isset($produto) && isset($corretor) && $tipoId > -1){
            $isPdf = false;
            $dataForm = $request->all();
            if(count($dataForm['files']) > 0){
                $path = 'files';
                foreach($dataForm['files'] as $key => $file){
                    $arquivo = $file;
                    $extencao = $arquivo->getClientOriginalExtension();
                    if($extencao == "pdf"){  
                        if(!$isPdf){
                            $negociacao = new Negociacao();
                            $negociacao->imovel_id = $request->imovel_id;
                            $negociacao->corretor_id = $request->corretor_id;
                            $negociacao->cliente_id = $cliente[0]->id;
                            $negociacao->status = "aguardando_revisão";
                            $negociacao->tipo_negociacao = $tipoId;
                            $negociacao->save();
                        }
                        $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                        $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                        $documento = new Documento();
                        $documento->url_modelo = url("storage/files/".$nomeArquivo);
                        $documento->documento = url("storage/files/".$nomeArquivo);
                        $documento->save();
                        $documento->negociacao()->attach($negociacao->id);
                        $isPdf = true;
                    }
                }
                if($isPdf){
                    return response()->json('Upload realizado com sucesso', 200);  
                }else{
                    return response()->json(["errors" => 'Arquivo nao corresponde'], 404);
                }
            }
        }else{
            return response()->json(["errors" => 'Dados não correpondem'], 404);
        }
    }
}
