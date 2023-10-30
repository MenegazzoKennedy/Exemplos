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
        $midias = Midia::where('produto_id', $id)->get();
        $contenTipo = TipoProduto::select('tipo_id')->where('produto_id', $id)->get();
        return view('imovel.edit')->with('tipos', $tiposProduto)->with('caracteristicasEnum', $caracteristica)->with('fontes', $fontes)->with(['produto' => Produto::find($id)])->with('contenTipo', $contenTipo)->with('midias', $midias)->with('caracteristicaTable', $caracteristicaTable);
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
            'valorProduto' => 'required|numeric',
            'destaque' => 'required|numeric',
            'status' => 'required|numeric',
            'tipos' => 'array',
        ]);
        $produto = Produto::find($id);
        if(isset($produto)){
            $produto->logradouro = $request->logradouro;
            $produto->numero = $request->numero;
            $produto->descricao = $request->descricao;
            $produto->slug = $request->slug;
            $produto->bairro = $request->bairro;
            $produto->fonte = $request->fonte;
            $produto->destaque = $request->destaque;
            $produto->titulo = $request->titulo;
            $produto->valor = $request->valorProduto;
            $produto->status = $request->status;
            $produto->detalhes = $request->detalhe;
            $produto->save();

            $contenTipo = TipoProduto::select('tipo_id')->where('produto_id', $id)->get();
            $contenTipo = json_decode($contenTipo, true);

            foreach ($contenTipo as $key => $tipoContem) {
                $tipo = $tipoContem['tipo_id'];
                if(!in_array($tipo,$request->tipos)){
                    $produto->tipos()->detach($tipo);
                }
            };

            if($request->tipos != null){
                foreach($request->tipos as $tipo){
                    $produto->tipos()->attach($tipo);
                }
            }

            if(isset($request->midiasCadastradas)){
                $midiasCadastradas2 = implode(" ", $request->midiasCadastradas);
            }else{
                $midiasCadastradas2 = "";
                $request->midiasCadastradas = "";
            }
            $midias = Midia::where('produto_id', $id)->get();
            foreach($midias as $key => $file){
                if(isset($request->midiasCadastradasModicadas)){
                    $indce = array_search($file->url_midia, $request->midiasCadastradasModicadas);
                }else{
                    $indce = -1;
                }
                if (strpos($midiasCadastradas2, $file->url_midia) === false) {
                    if(isset($request->inpuMidias[$indce])){
                        unset($request->inpuMidias[$indce]);
                    }
                    $file->delete();
                }
                if(!isset($request->inpuMidias[$indce])){
                    if($file->is_destaque == 1 || isset($request->midia_destaque[$indce])){
                        $midia = Midia::find($file->id);
                        if(isset($midia)){
                            if(isset($request->midia_destaque[$indce]) && $file->is_destaque != 1){
                                $midia->is_destaque = 1;
                                $midia->save();
                            }else if(!isset($request->midia_destaque[$indce]) && $file->is_destaque == 1){
                                $midia->is_destaque = 0;
                                $midia->save(); 
                            }
                        }
                    } 
                }
                if($request->midiasCadastradasModicadas != ""){
                    $indce2 = array_search($file->url_midia, $request->midiasCadastradas);
                    if($indce2 != false){
                        if(isset($request->inpuMidias[$indce2])){
                            $midia = Midia::find($file->id);
                            $file->delete();
                        }
                    } 
                }
                
            }

            
            if(isset($request->inpuMidias)){
                $path = 'files';
                foreach($request->inpuMidias as $key => $file){
                    if(isset($file)){
                        $arquivo = $file;
                        $extencao = $arquivo->getClientOriginalExtension();
                        $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                        $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                        $midia = new Midia();
                        $midia->url_midia = url("storage/files/".$nomeArquivo);
                        $midia->produto_id = $produto->id;
                        if(isset($request->midia_destaque[$key])){
                            $midia->is_destaque = 1;
                        }else{
                            $midia->is_destaque = 0;
                        }                    
                        $midia->save();
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
                'bairro' => 'required|string',
                'logradouro' => 'required|string',
                'descricao' => 'required|string',
                'slug' => 'required|string',
                'fonte' => 'required|integer',
                'titulo' => 'required|string',
                'detalhe' => 'required|string',
                'numero' => 'required|numeric',
                'valorProduto' => 'required|numeric',
                'destaque' => 'required|numeric',
                'status' => 'required|numeric',
                'tipos' => 'array',
                'files' => 'array',
                'descricaoCaracteristica' => 'array',
                'quantidade' => 'array',
                'distanciaCaracteristicas' => 'array',
                'valorCaracteristica' => 'array',
            ]);
            
            $produto = new Produto();
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

            if(isset($request->inpuMidias)){
                $path = 'files';
                foreach($request->inpuMidias as $key => $file){
                    $arquivo = $file;
                    $extencao = $arquivo->getClientOriginalExtension();
                    $nomeArquivo = uniqid(date('Ymdhis'.$key)).'.'.$extencao;
                    $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);
                    $midia = new Midia();
                    $midia->url_midia = url("storage/files/".$nomeArquivo);
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
