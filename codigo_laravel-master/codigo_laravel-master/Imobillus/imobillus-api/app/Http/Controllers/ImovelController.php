<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tipo;
use App\Enums\Descricao;
use App\Enums\CaracteristicasEnum;
use App\Enums\Fontes;
use App\Models\Produto;
use App\Models\TipoProduto;
use App\Models\Midia;
use App\Models\Caracteristica;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Bairro;
use Auth;

class ImovelController extends Controller
{
    public function index()
    {
        $produtos = Produto::paginate(20);
        return view('imovel.index')->with('produtos', $produtos);
    }
    public function edit($id)
    {
        $tiposProduto = Tipo::all();
        $caracteristica = Descricao::getKeys();
        $caracteristicaTable = Caracteristica::where('produto_id', $id)->get();
        $fontes = Fontes::getKeys();
        $produto = Produto::find($id);
        $estados = Estado::all();
        $bairros = Bairro::find($produto->bairro_id);
        $cidade_id = $bairros->cidade_id;
        $cidades = Cidade::find($cidade_id);
        $estado_id = $cidades->estados_id;
        $bairros = Bairro::where('cidade_id', $cidade_id)->get();
        $cidades = Cidade::where('estados_id', $estado_id)->get();
        $midias = Midia::where('produto_id', $id)->get();
        $contenTipo = TipoProduto::select('tipo_id')->where('produto_id', $id)->get();
        return view('imovel.edit')->with('tipos', $tiposProduto)->with('caracteristicasEnum', $caracteristica)->with('fontes', $fontes)->with(['produto' => Produto::find($id)])->with('contenTipo', $contenTipo)->with('midias', $midias)->with('caracteristicaTable', $caracteristicaTable)->with('estados', $estados)->with('estado_id', $estado_id)->with('cidade_id', $cidade_id)->with('cidades', $cidades)->with('bairros', $bairros)->with('bairro_id', $produto->bairro_id);  
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'bairro' => 'required|string',
            'logradouro' => 'required|string',
            'descricao' => 'required|string',
            'slug' => 'required|string',
            'fonte' => 'required|integer',
            'titulo' => 'required|string',
            'detalhe' => 'required|string',
            'numero' => 'required|numeric',
            'valorProduto' => 'required|string',
            'destaque' => 'required|numeric',
            'status' => 'required|numeric',
            'tipos' => 'array',
            'idMidia' => 'array',
            'midiaRemovida' => 'array',
        ]);
        $produto = Produto::find($id);
        if(isset($produto)){
            $produto->logradouro = $request->logradouro;
            $produto->numero = $request->numero;
            $produto->descricao = $request->descricao;
            $produto->slug = $request->slug;
            $produto->bairro_id = $request->bairro;
            $produto->fonte = $request->fonte;
            $produto->destaque = $request->destaque;
            $produto->titulo = $request->titulo;
            $produto->valor = $request->valorProduto;
            $produto->status = $request->status;
            $produto->detalhes = $request->detalhe;
            $produto->save();

            $contenTipo = TipoProduto::select('tipo_id')->where('produto_id', $id)->get();

            if(isset($contenTipo[0])){
                $contenTipo = json_decode($contenTipo, true);
                foreach ($contenTipo as $key => $tipoContem) {
                    $tipo = $tipoContem['tipo_id'];
                    
                    if(isset($request->tipos)){
                        if(!in_array($tipo,$request->tipos)){
                            $produto->tipos()->detach($tipo);
                        }
                        
                    }else{
                        $produto->tipos()->detach($tipo);
                    }
                }
                $contenTipo = TipoProduto::select('tipo_id')->where('produto_id', $id)->get();
                if(isset($contenTipo[0])){
                    foreach($request->tipos as $key => $tipoContem2){
                        $possui = false;
                        foreach ($contenTipo as $key => $tipoContem) {
                            $tipo = $tipoContem['tipo_id'];
                            if($tipo == $tipoContem2){
                                $possui = true;
                            }
                        }
                        if(!$possui){
                            $produto->tipos()->attach($tipoContem2);
                        }
                    }
                }
                
            }else{
                if(isset($request->tipos)){
                    foreach($request->tipos as $key => $tipoContem2){
                        $produto->tipos()->attach($tipoContem2);
                    }
                }
            }

            if($request->midiaRemovida != null){
                foreach($request->midiaRemovida as $exluir){
                    $mediaVerifica = Midia::find($exluir);
                    if(isset($mediaVerifica)){
                        $mediaVerifica->delete();
                    }                    
                }
            }
            if(isset($request->idMidia)){
                foreach($request->idMidia as $key => $file){
                    if(isset($request->midia_destaque[$key])){
                        $destaque = 1;
                    }else{
                        $destaque = 0;
                    } 
                    if(isset($request->idMidia[$key])){
                        $mediaVerifica = Midia::find($request->idMidia[$key]);
                    }
                    if(isset($mediaVerifica)){
                        if($mediaVerifica->is_destaque != $destaque){
                            $mediaVerifica->is_destaque = $destaque;
                        }
                        $mediaVerifica->save();
                    }
                }
            }
            
            if(isset($request->inpuMidias)){
                
                $path = 'files';
                foreach($request->inpuMidias as $key => $file){
                    if(isset($file)){
                        $mediaVerifica = null;
                        $arquivo = $file;
                        if(isset($request->midia_destaque[$key])){
                            $destaque = 1;
                        }else{
                            $destaque = 0;
                        } 
                        if(isset($request->idMidia[$key])){
                            $mediaVerifica = Midia::find($request->idMidia[$key]);   
                        }
                        if(!is_null($mediaVerifica)){
                            if($mediaVerifica->url_midia != $arquivo || $mediaVerifica->is_destaque != $destaque){
                                if($mediaVerifica->is_destaque != $destaque){
                                    $mediaVerifica->is_destaque = $destaque;
                                }
                                if($mediaVerifica->url_midia != $arquivo){
                                    $extencao = $arquivo->getClientOriginalExtension();
                                    $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                                    $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                                    $mediaVerifica->url_midia = "storage/files/".$nomeArquivo;
                                }
                                
                                $mediaVerifica->save();
                            }
                        }else{             
                            $extencao = $arquivo->getClientOriginalExtension();
                            $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                            $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                            $midia = new Midia();
                            $midia->url_midia = "storage/files/".$nomeArquivo;
                            $midia->produto_id = $id;
                            $midia->is_destaque = $destaque;                  
                            $midia->save();
                        }
                    }
                }
            }

            
            $caracteristica = Caracteristica::where('produto_id',$id)->delete();
           
            if($request->quantidadeCont > 0){
                
                for($i = 1; $i <= $request->quantidadeCont; $i++){
                    $caracteristica = new Caracteristica();
                    $salvarCaracteristica = false;
                    if(isset($request->iconeCaracteristica[$i])){
                        $caracteristica->icone = $request->iconeCaracteristica[$i];
                        $salvarCaracteristica = true;
                    }
                    
                    if(isset($request->descricaoCaracteristica[$i])){
                        if($request->descricaoCaracteristica[$i] == 'Outro'){
                            $caracteristica->descricao = $request->descricaoCaracteristica2[$i];
                        }else{
                            $caracteristica->descricao = $request->descricaoCaracteristica[$i];
                            if($request->descricaoCaracteristica[$i] == 'AreaUtil'){
                                $caracteristica->icone = 'area_util';
                            }else if($request->descricaoCaracteristica[$i] == 'Banheiros'){
                                $caracteristica->icone = 'banheiro';
                            }else if($request->descricaoCaracteristica[$i] == 'Garagem'){
                                $caracteristica->icone = 'garagem';
                            }else if($request->descricaoCaracteristica[$i] == 'Lavanderia'){
                                $caracteristica->icone = 'lavanderia';
                            }else if($request->descricaoCaracteristica[$i] == 'Quartos'){
                                $caracteristica->icone = 'quarto';
                            }else if($request->descricaoCaracteristica[$i] == 'Suíte'){
                                $caracteristica->icone = 'suite';
                            }
                            if(($request->descricaoCaracteristica[$i] == 'latitude' || $request->descricaoCaracteristica[$i] == 'longitude') && !isset($request->valorCaracteristica[$i])){
                                $caracteristica->valor = 0;
                            }
                        }
                        $salvarCaracteristica = true;
                    }
                    if(isset($request->quantidade[$i])){
                        $caracteristica->quantidade = $request->quantidade[$i];
                        $salvarCaracteristica = true;
                    }
                    if(isset($request->distanciaCaracteristicas[$i])){
                        if($request->distanciaCaracteristicas[$i] == "sim"){
                            $caracteristica->is_coord = 1;
                        }else{
                            $caracteristica->is_coord = 0;
                        }                        
                        $salvarCaracteristica = true;
                    }
                    if(isset($request->valorCaracteristica[$i])){
                        $caracteristica->valor = $request->valorCaracteristica[$i];
                        $salvarCaracteristica = true;
                        if($request->descricaoCaracteristica[$i] == 'latitude' || $request->descricaoCaracteristica[$i] == 'longitude'){
                            $caracteristica->is_coord = 1;
                        }
                    }
                    if($salvarCaracteristica){
                        $caracteristica->produto_id = $produto->id; 
                        $caracteristica->save(); 
                    }
                }
            }
            return redirect()->route('dashboard.produtos.index');
        }else{
            return redirect()->route('dashboard.imovel.index')->with('sweet-warning', 'Não existe imovel com esse id');
        }
    }
    public function cadastraImovel(Request $request)
    {   
        if(Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('gestor_regional')){
            $request->validate([
                'bairro' => 'required|numeric',
                'logradouro' => 'required|string',
                'descricao' => 'required|string',
                'slug' => 'required|string|unique:produtos',
                'fonte' => 'required|integer',
                'titulo' => 'required|string',
                'detalhe' => 'required|string',
                'numero' => 'required|numeric',
                'valorProduto' => 'required|string',
                'destaque' => 'required|numeric',
                'status' => 'required|numeric',
                'cep' => 'required|string',
                'tipos' => 'array',
                'files' => 'array',
                'descricaoCaracteristica' => 'array',
                'quantidade' => 'array',
                'distanciaCaracteristicas' => 'array',
                'valorCaracteristica' => 'array',
            ]);
            
            $produto = new Produto();
            $produto->bairro_id = $request->bairro;
            $produto->logradouro = $request->logradouro;
            $produto->numero = $request->numero;
            $produto->descricao = $request->descricao;
            $produto->slug = $request->slug;
            
            $produto->fonte = $request->fonte;
            $produto->destaque = $request->destaque;
            $produto->titulo = $request->titulo;
            $produto->valor = $request->valorProduto;
            $produto->status = $request->status;
            $produto->detalhes = $request->detalhe;
            $produto->cep = $request->cep;
            $produto->save();

            if(isset($request->inpuMidias)){
                $path = 'files';
                foreach($request->inpuMidias as $key => $file){
                    $arquivo = $file;
                    $extencao = $arquivo->getClientOriginalExtension();
                    $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                    $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                    $midia = new Midia();
                    $midia->url_midia = "storage/files/".$nomeArquivo;
                    $midia->produto_id = $produto->id;
                    if(isset($request->midia_destaque[$key])){
                        $midia->is_destaque = 1;
                    }else{
                        $midia->is_destaque = 0;
                    }                    
                    $midia->save();
                }
            }
            if($request->tipos != null){
                foreach($request->tipos as $tipo){
                    $produto->tipos()->attach($tipo);
                }
            }                
            for($i = 1; $i <= $request->quantidadeCont; $i++){
                $caracteristica = new Caracteristica();
                $caracteristicaEnum = CaracteristicasEnum::getKeys();
                $salvarCaracteristica = false;
                if(isset($request->iconeCaracteristica[$i])){
                    $caracteristicaEnum = CaracteristicasEnum::getKeys();
                    foreach($caracteristicaEnum as $key => $caracteristica){
                        if($caracteristica == $request->iconeCaracteristica[$i]){
                            $caracteristica->icone = 'area_util';
                            $salvarCaracteristica = true;
                        }
                    }                    
                }
                
                if(isset($request->descricaoCaracteristica[$i])){
                    if($request->descricaoCaracteristica[$i] == 'Outro'){
                        $caracteristica->descricao = $request->descricaoCaracteristica2[$i];
                    }else{
                        $caracteristica->descricao = $request->descricaoCaracteristica[$i];
                        if($request->descricaoCaracteristica[$i] == 'AreaUtil'){
                            $caracteristica->icone = 'area_util';
                        }else if($request->descricaoCaracteristica[$i] == 'Banheiros'){
                            $caracteristica->icone = 'banheiro';
                        }else if($request->descricaoCaracteristica[$i] == 'Garagem'){
                            $caracteristica->icone = 'garagem';
                        }else if($request->descricaoCaracteristica[$i] == 'Lavanderia'){
                            $caracteristica->icone = 'lavanderia';
                        }else if($request->descricaoCaracteristica[$i] == 'Quartos'){
                            $caracteristica->icone = 'quarto';
                        }else if($request->descricaoCaracteristica[$i] == 'Suíte'){
                            $caracteristica->icone = 'suite';
                        }

                        if(($request->descricaoCaracteristica[$i] == 'latitude' || $request->descricaoCaracteristica[$i] == 'longitude') && !isset($request->valorCaracteristica[$i])){
                            $caracteristica->valor = 0;
                        }
                    }
                    $salvarCaracteristica = true;
                }
                if(isset($request->quantidade[$i])){
                    $caracteristica->quantidade = $request->quantidade[$i];
                    $salvarCaracteristica = true;
                }
                if(isset($request->distanciaCaracteristicas[$i])){
                    if($request->distanciaCaracteristicas[$i] == "sim"){
                        $caracteristica->is_coord = 1;
                    }else{
                        $caracteristica->is_coord = 0;
                    }                        
                    $salvarCaracteristica = true;
                }
                if(isset($request->valorCaracteristica[$i])){
                    $caracteristica->valor = $request->valorCaracteristica[$i];
                    $salvarCaracteristica = true;
                    if($request->descricaoCaracteristica[$i] == 'latitude' || $request->descricaoCaracteristica[$i] == 'longitude'){
                        $caracteristica->is_coord = 1;
                    }
                }
                if($salvarCaracteristica){
                    $caracteristica->produto_id = $produto->id; 
                    $caracteristica->save(); 
                }
            }
            
            return redirect()->route('dashboard.produtos.index');
        }
        return redirect()->route('dashboard.imovel.index')->with('sweet-warning', 'Você não possui permição para cadastrar produtos');
    }
    public function cadastraImovelView(){
        $tiposProduto = Tipo::all();
        $tipos = Descricao::getKeys();
        $fontes = Fontes::getKeys();
        $estado = Estado::all();
        return view('imovel.new')->with('tipos', $tiposProduto)->with('tiposEnum', $tipos)->with('fontes', $fontes)->with('estados', $estado);        
    }
    public function imovelStatus($id){
        $produto = Produto::find($id);
        if(isset($produto)){
            if($produto->status == 1){
                $produto->status = 0;
            }else if($produto->status == 0){
                $produto->status = 1;
            }
            $produto->save();
            return redirect()->route('dashboard.produtos.index')->with('sweet-success', 'Status Produto atualizado');
        }else{
            return redirect()->route('dashboard.produtos.index')->with('sweet-warning', 'Não existe produto com esse id');
        }
    }
    public function imovelEstado(Request $request){
        $cidades = Estado::with(['cidades' => function($e){
            $e->orderBy('name');
        }])->where("id",$request->id)->get();
        return response()->json($cidades,200);
    }
    public function imovelCidade(Request $request){
        $bairros = Cidade::with(['bairros' => function($e){
            $e->orderBy('name');
        }])->where("id",$request->id)->get();
        return response()->json($bairros,200);
    }
}
