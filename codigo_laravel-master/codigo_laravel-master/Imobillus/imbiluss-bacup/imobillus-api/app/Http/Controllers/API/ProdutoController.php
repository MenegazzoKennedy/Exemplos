<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\User;
use App\Models\Visita;
use App\Models\Tipo;
use App\Models\Feedback;
use App\Models\TipoProduto;
use App\Models\Caracteristica;
use App\Models\Midia;
use App\Models\Bairro;
use App\Models\Role;
use Auth;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $bairro;
    public function index()
    {
        $produtos = Produto::with(['tipos' => function($q){
            $q->where("status", '1');
        },'midias','caracteristicas'])->get();
        if(count($produtos) > 0){
            return response()->json($produtos,200); 
        }else{
            return response()->json(["errors" => 'Nenhum produto encontrado'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('gestor_regional')){
            $request->validate([
                'logradouro' => 'required|string',
                'numero' => 'required|string',
                'descricao' => 'required|string',
                'valor' => 'required|string',
                'bairro' => 'required|string',
                'fonte' => 'required|integer',
                'destaque' => 'required|integer',
            ]);
            $produto = new Produto();
            $produto->logradouro = $request->logradouro;
            $produto->numero = $request->numero;
            $produto->descricao = $request->descricao;
            $produto->valor = $request->valor;
            $produto->bairro = $request->bairro;
            $produto->fonte = $request->fonte;
            $produto->destaque = $request->destaque;
            $produto->save();
            return response()->json($produto,201);
        }
        return response()->json(["errors" => 'Você não possui permição para cadastrar produtos'], 203);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::with('categorias','midias','caracteristicas')->where("slug",$id)->get();
        if(isset($produto)){
            return response()->json($produto[0],200);
        }
        return response()->json(["errors" => 'Produto não encontrado'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('gestor_regional')){
            $produto = Produto::find($id);
            if(isset($produto)){
                $request->validate([
                    'logradouro' => 'string',
                    'numero' => 'string',
                    'descricao' => 'string',
                    'valor' => 'string',
                    'bairro' => 'string',
                    'fonte' => 'integer',
                    'destaque' => 'integer',
                ]);
                $save = false;
                if(isset($request->logradouro)){
                    $produto->logradouro = $request->logradouro;
                    $save = true;
                }
                if(isset($request->numero)){
                    $produto->numero = $request->numero;
                    $save = true;
                }
                if(isset($request->descricao)){
                    $produto->descricao = $request->descricao;
                    $save = true;
                }
                if(isset($request->valor)){
                    $produto->valor = $request->valor;
                    $save = true;
                }
                if(isset($request->bairro)){
                    $produto->bairro = $request->bairro;
                    $save = true;
                }
                if(isset($request->fonte)){
                    $produto->fonte = $request->fonte;
                    $save = true;
                }
                if(isset($request->destaque)){
                    $produto->destaque = $request->destaque;
                    $save = true;
                }
                if($save){
                    $produto->save();
                    return response()->json($produto,201);
                }
                return response()->json(["errors" => 'Não foi enviado dados para atualizar os produtos'], 412);
            }
            return response()->json(["errors" => 'Produto não encontrado'], 404);
        }
        return response()->json(["errors" => 'Você não possui permição para atualizar produtos'], 203);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('gestor_regional')){
            $produto = Produto::find($id);
            if(isset($produto)){ 
                $produto->delete();
                return response('Produto deletado com sucesso', 200);
            }
            return response()->json(["errors" => 'Produto não encontrado'], 404);
        }
        return response()->json(["errors" => 'Você não possui permição para deletar produtos'], 203);
    }
    public function agendaVisita($id, Request $request) {
        $user = User::find(Auth::id())->roles()->get();
        if($user[0]->id == 2){
            $cliente = Cliente::where("user_id",$user[0]->pivot['user_id'])->get(); 
            $request->validate([
                'data' => 'required|date|after:tomorrow',
                'is_presencial'=>'required|integer',
            ]);
            $visita = new Visita();
            $produto = Produto::find($id);
            if(!isset($produto)){
                return response()->json(["errors" => 'Produto não encontrado'], 404);
            }else{
                $visita->produto_id = $id;
            }
            
            if($request->corretor_id){
                $corretor = Corretor::find($request->corretor_id);
                if(!isset($corretor->id)){
                    return response()->json(["errors" => 'Corretor não encontrado'], 404);
                }else{
                    if(isset($request->corretor_id)){
                        $visita->corretor_id = $corretor->id;
                        $user = User::find($corretor->user_id);
                        $enviaEmail = $user->enviaEmailCorretor($produto->titulo);
                    }
                }
            }else{
                //metodo sem corretor
                $visita->corretor_id = 1; 
                $this->bairro = $produto->bairro;
                $bairros = Bairro::with('corretores.user')->where('name', $this->bairro)->first(); 
                if(isset($bairros)){
                    foreach($bairros['corretores'] as $bairro){
                        $bairro->user->enviaEmailCorretor($produto->titulo);
                    }
                }else{
                    $user = Role::with('users')->where('name', 'gestor_regional')->get();
                    foreach($user[0]['users'] as $gestor){
                        $gestor->enviaEmailGestor($produto->titulo);
                    }
                }
                
            }

            $visita->is_presencial = $request->is_presencial;
            $visita->data = $request->data;
            $visita->cliente_id = $cliente[0]->id;
            $visita->save();
            return response()->json($visita,201);
        }
        return response()->json(["errors" => 'Você não possui permição para agendar uma visita'], 203);
    }
    public function visitasAgendadas($id) {
        if($id == "me"){
            if(Auth::user()->hasAnyRole('cliente')){
                $visita = Cliente::with(['visitas.feedback'])->where("user_id",Auth::id())->get();
            }else if(Auth::user()->hasAnyRole('corretor')){
                $visita = Corretor::with(['visitas.feedback'])->where("user_id",Auth::id())->get();
            }else{
                return response()->json(["errors" => 'Você não possui visita agendada'], 404);
            }
            if(count($visita) > 0){
                return response()->json($visita,200);
            }else{
                return response()->json(["errors" => 'Você não possui visita agendada'], 404);
            } 
        }else{
            if(Auth::user()->hasAnyRole('cliente')){
                $visitas = Cliente::with(['visitas.feedback'])->where("user_id",Auth::id())->get();
            }else if(Auth::user()->hasAnyRole('corretor')){
                $visitas = Corretor::with(['visitas.feedback'])->where("user_id",Auth::id())->get();
            }else{
                return response()->json(["errors" => 'Você não possui permicao'], 404);
            }
            if(count($visitas) > 0){
                foreach($visitas[0]->visitas as $visita){
                    if($visita->id = $id){
                        return response()->json($visita,200);
                    }
                }
                return response()->json(["errors" => 'Não existe visita com esse id'], 404);
            }else{
                return response()->json(["errors" => 'Você não possui visita agendada'], 404);
            } 
        }
    }
    public function updateVisita($id, Request $request) {
        $request->validate([
            'data' => 'date|after:tomorrow',
            'is_presencial'=>'integer'
        ]);
        $cliente = Cliente::where("user_id",Auth::id())->get(); 
        if(isset($cliente[0])){
            $visita = Visita::find($id);
            if(isset($visita)){
                if($visita->cliente_id == $cliente[0]->id){
                    if(isset($request->data) || isset($request->is_presencial)){
                        if(isset($request->data)){
                            $visita->data = $request->data;
                        }
                        if(isset($request->is_presencial)){
                            $visita->is_presencial = $request->is_presencial;
                        }
                        $visita->save();
                        return response()->json($visita,200);
                    }else{
                        return response()->json(["errors" => 'Não foram enviados dados para modificar a visita'], 412);
                    }
                }else{
                    return response()->json(["errors" => 'Vocé não pode modificar uma visita que não é sua'], 203);
                }
            }else{
                return response()->json(["errors" => 'Não existe nenhuma visita agendada com esse id'], 404);
            } 
        }else{
            return response()->json(["errors" => 'Vocé não possui permição para modificar visitas'], 203);
        }
    }

    public function feedbackVisita($id, Request $request) {
        $request->validate([
            'avaliacao'=>'required|boolean',
            'comentario' => 'required|string',
        ]);
        if(!isset($id)){
            return response()->json(["errors" => 'Vocé não enviou o id visitas'], 412);
        }
        $cliente = Cliente::where("user_id",Auth::id())->get();
        $corretor = Corretor::where("user_id",Auth::id())->get();
        if(isset($cliente[0]) || isset($corretor[0])){
            
            $visita = Visita::where("id",$id)
            ->where(function($query) {
                $cliente = Cliente::where("user_id",Auth::id())->get();
                $corretor = Corretor::where("user_id",Auth::id())->get();
                isset($cliente[0]->id) ? $cliente_id = $cliente[0]->id : $cliente_id = -1;  
                isset($corretor[0]->id) ? $corretor_id = $corretor[0]->id : $corretor_id = -1;  
                $query->where("cliente_id", $cliente_id)
                      ->orWhere("corretor_id", $corretor_id);
            })->get();
            if(isset($visita[0])){
                if($visita[0]->data < now()){
                    $feedback = Feedback::where("visita_id", $visita[0]->id)->where("user_id",Auth::id())->get();
                    if(!isset($feedback[0])){
                        $newFeedback = new Feedback();
                        $newFeedback->user_id = Auth::id();
                        $newFeedback->visita_id = $visita[0]->id;
                        $newFeedback->avaliacao = $request->avaliacao;
                        $newFeedback->comentario = $request->comentario;
                        $newFeedback->data = now();
                        $newFeedback->save();
                        return response()->json($newFeedback,200);
                    }else{
                        return response()->json(["errors" => 'Vocé já possui feedback nessa visita'], 203);
                    }
                }else{
                    return response()->json(["errors" => 'Essa visita ainda não foi efetuada'], 203);
                }
            }else{
                return response()->json(["errors" => 'Vocé não possui permição para dar feedback nessa visita'], 203);
            }
        }else{
            return response()->json(["errors" => 'Vocé não possui permição para dar feedback em visitas'], 203);
        }
    }
    public function categoria($slug) {
        if($slug == "all"){
            $tipo = Tipo::with(['produto.midias', 'produto.caracteristicas'])->where("status", '1')->get();
            return $tipo; 
            if(count($tipo) > 0){
                return response()->json($tipo,200); 
            }else{
                return response()->json(["errors" => 'Não existem produtos cadastrados por categoria'], 404);
            }
        }else{
            $tipo = Tipo::with(['produto.midias', 'produto.caracteristicas'])->where("slug",'=',$slug)->where("status", '1')->get();
            if(count($tipo) > 0){
                return response()->json($tipo,200); 
            }else{
                return response()->json(["errors" => 'Não existem produtos cadastrados nessa categoria'], 404);
            }
        }
    }

    public function produtoDestaque()
    {
        $produtos = Produto::with(['tipos' => function($q){
            $q->where("status", '1');
        },'midias','caracteristicas'])->where("destaque", 1)->get();
        return $produtos;
        if(count($produtos) > 0){
            return response()->json($produtos,200); 
        }else{
            return response()->json(["errors" => 'Nenhum produto encontrado'], 404);
        }
    }
}