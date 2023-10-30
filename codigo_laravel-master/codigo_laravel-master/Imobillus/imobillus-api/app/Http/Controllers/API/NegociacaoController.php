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

        if ($request->imovel_id) {
            $produto = Produto::find($request->imovel_id);
            if (!$produto) {
                return response()->json(["errors" => 'Produto não encontrado'], 404);
            }
        }       
        

        if ($request->corretor_id) {
            $corretor = Corretor::find($request->corretor_id);
            if (!$corretor) {
                return response()->json(["errors" => 'Corretor não encontrado'], 404);
            }
        } 
        
        //relacionamento é com usuario e nao com cliente
        $cliente = Cliente::where('user_id', Auth::user()->id)->get();        
        if (!$cliente) {
            return response()->json(["errors" => 'Usuário não é cliente'], 404);
        }

        $tipo = TipoNegociacao::getValue($request->tipo_negociacao);

        //return response()->json(["errors" => $tipo], 404);

        if($tipo >= 0){

            $negociacao = new Negociacao();
            $negociacao->imovel_id = $request->imovel_id;
            $negociacao->corretor_id = $request->corretor_id;
            $negociacao->cliente_id = $cliente[0]->id;
            $negociacao->status = "aguardando_revisao";
            $negociacao->tipo_negociacao = $tipo;
            $negociacao->save();

            $isPdf = false;
            $dataForm = $request->all();
            if(count($dataForm['files']) > 0){
                $path = 'files';
                foreach($dataForm['files'] as $key => $file){
                    $arquivo = $file;
                    $extencao = $arquivo->getClientOriginalExtension();
                    if($extencao == "pdf"){  
                        
                        $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                        $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                        $documento = new Documento();
                        //$documento->url_modelo = $nomeArquivo;
                        $documento->documento = $nomeArquivo;
                        $documento->descricao = "-";
                        $documento->tipo = "documento";
                        $documento->negociacao_id = $negociacao->id;
                        $documento->save();
                        //$documento->negociacao()->attach($negociacao->id);
                        $isPdf = true;
                    }
                }
                if($isPdf){   
                    $negociacao['documentos'] = $negociacao->documentos()->get();                                   
                    return response()->json($negociacao, 200);
                }else{
                    $negociacao->status = "arquivos_invalidos";
                    $negociacao->save();
                    return response()->json(["errors" => 'Arquivo nao corresponde'], 404);
                }
            }
        }else{
            return response()->json(["errors" => 'Dados tipo negociação não correpondem '.$request->tipo_negociacao], 404);
        }
    }
}
