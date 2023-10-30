<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Follower;
use App\Models\Corretor;
use App\Models\Cliente;
use App\Models\Bairro;
use App\Models\BairroCorretor;
use App\Models\Regiao;
use App\Models\CorretorRegiao;
use App\Enums\Generos;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Preferido;
use Auth;
//use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.index')->with('users', User::paginate(20));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //controle para o propio usuario nao se editar
        if(Auth::user()->id == $id){
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Você não tem permissão para editar sua própia conta');
        }
        $corretor = false;
        $cliente = false;
        $user = User::with('roles')->where('id',$id)->get();
        foreach($user[0]['roles'] as $role){
            if($role->name == 'corretor'){
                $corretor = true;
            }
            if($role->name == 'cliente'){
                $cliente = true;
            }
        }
        if($corretor){
            $generos = Generos::getKeys();
            $estado = Estado::all();
            if($cliente){
                $usuario = User::with(['corretores.bairros.cidade','corretores.regioes.cidade','roles','clientes'])->where('id',$id)->get();
                $corretorPreferido = Corretor::find($usuario[0]->clientes[0]->corretor_id_preferido);
                if(isset($usuario[0]["corretores"][0]['bairros'][0]) || isset($usuario[0]["corretores"][0]['regioes'][0])){
                    if(isset($usuario[0]["corretores"][0]['bairros'][0])){
                        $idCidade = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['estados_id'];
                    }else{
                        $idCidade = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['estados_id'];
                    }
                    $cidade = Cidade::with('bairros','regioes')->where('estados_id', $idestado)->get();
                    
                    return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos, 'estados' => $estado,'idCidade' => $idCidade, 'idEstado' => $idestado, 'cidades' => $cidade, 'corretorPreferido' => $corretorPreferido]);
                }
                return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos, 'estados' => $estado, 'corretorPreferido' => $corretorPreferido]);
            }else{
                $usuario = User::with('corretores.bairros.cidade','corretores.regioes.cidade','roles')->where('id',$id)->get();
                if(isset($usuario[0]["corretores"][0]['bairros'][0]) || isset($usuario[0]["corretores"][0]['regioes'][0])){
                    if(isset($usuario[0]["corretores"][0]['bairros'][0])){
                        $idCidade = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['estados_id'];
                    }else{
                        $idCidade = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['estados_id'];
                    }
                    $cidade = Cidade::with('bairros','regioes')->where('estados_id', $idestado)->get();
                    return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos, 'estados' => $estado,'idCidade' => $idCidade, 'idEstado' => $idestado, 'cidades' => $cidade]);
                }
                return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos,'estados' => $estado]);
            }
        }else if($cliente){
            $generos = Generos::getKeys();
            $estado = Estado::all();
            if($corretor){
                $usuario = User::with(['corretores.bairros.cidade','corretores.regioes.cidade','clientes','roles'])->where('id',$id)->get();
                $corretorPreferido = Corretor::find($usuario[0]->clientes[0]->corretor_id_preferido);
                if(isset($usuario[0]["corretores"][0]['bairros'][0]) || isset($usuario[0]["corretores"][0]['regioes'][0])){
                    if(isset($usuario[0]["corretores"][0]['bairros'][0])){
                        $idCidade = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['bairros'][0]['cidade']['estados_id'];
                    }else{
                        $idCidade = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['id'];
                        $idestado = $usuario[0]["corretores"][0]['regioes'][0]['cidade']['estados_id'];
                    }
                    $cidade = Cidade::with('bairros','regioes')->where('estados_id', $idestado)->get();
                    return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos, 'estados' => $estado,'idCidade' => $idCidade, 'idEstado' => $idestado, 'cidades' => $cidade, 'corretorPreferido' => $corretorPreferido]);
                }
                return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos,'estados' => $estado, 'corretorPreferido' => $corretorPreferido]);
            }else{
                $usuario = User::with('clientes','roles')->where('id',$id)->get();
                $corretorPreferido = Corretor::find($usuario[0]->clientes[0]->corretor_id_preferido);
                return view('usuarios.edit')->with(['usuario' => $usuario[0], 'roles' => Role::all(), 'generos' => $generos, 'estados' => $estado, 'corretorPreferido' => $corretorPreferido]);
            }
        }else{
            $usuario = User::find($id);
            return view('usuarios.edit')->with(['usuario' => $usuario, 'roles' => Role::all()]);
        }
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

        $request->validate([
            'nome' => 'string',
            'nascimento' => 'date',
            'telefone' => 'numeric'
        ]);
        //controle para o propio usuario nao se editar
        if(Auth::user()->id == $id){
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Você não tem permissão para editar sua própia conta');
        }

        $user = User::find($id);
        $user->roles()->sync($request->roles);
        $userMudar = false;
        if(isset($request->nome)){
            if($user->name != $request->nome){
                $user->name = $request->nome;
                $userMudar = true;
            }
        }
        if(isset($request->email)){
            if($user->email != $request->email){
                $request->validate([
                    'email' => 'required|string|email|max:255|unique:users',
                ]);
                $user->email = $request->email;
                $userMudar = true;
            }
        }
        if($userMudar){
            $user->save();
        }
        $userMudar = false;
        $cliente = Cliente::where('user_id',$id)->get();
        
        if(!isset($cliente[0])){
            $cliente = new Cliente();
            $cliente->user_id = $id;
        }else{
            $cliente = $cliente[0];
        }
        
        if(isset($request->cpf)){
            if($cliente->cpf != $request->cpf){
                $request->validate([
                    'cpf' => 'required|string|max:255|unique:clientes',
                ]);
                $cliente->cpf = $request->cpf;
                $userMudar = true;
            }
        }
        if(isset($request->nascimento)){
            if($cliente->nascimento != $request->nascimento){
                $cliente->nascimento = $request->nascimento;
                $userMudar = true;
            }
        }
        if(isset($request->telefone)){
            if($cliente->telefone != $request->telefone){
                $cliente->telefone = $request->telefone;
                $userMudar = true;
            }
        }
        
        if(isset($request->termos_servico)){
            if($cliente->termos_servico != $request->termos_servico){
                $cliente->termos_servico = $request->termos_servico;
                $userMudar = true;
            }
        }
        if(isset($request->fotoCliente)){
            $path = 'files';
            $arquivo = $request->fotoCliente;
            $extencao = $arquivo->getClientOriginalExtension();
            if($extencao == "jpeg" || $extencao == "png" || $extencao == "jpg"){ 
                $nomeArquivo = uniqid(date('Ymdhis')).'.'.$extencao;
                $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);

                $cliente->url_foto = "storage/files/".$nomeArquivo;
                $userMudar = true;
            }
        }
        if(isset($request->genero)){
            if($cliente->genero != $request->genero){
                $cliente->genero = $request->genero;
                $userMudar = true;
            }
        }
        
        if($userMudar){
            
            $cliente->save();
        }
        

        $corretor = Corretor::where('user_id',$id)->get();
        $userMudar = false;
        
        if(!isset($corretor[0])){
            $corretor = new Corretor();
            $corretor->user_id = $id;
        }else{
            $corretor = $corretor[0];
        }
        
        if(isset($request->creci)){
            if($corretor->creci != $request->creci){
                $request->validate([
                    'creci' => 'unique:corretores',
                ]);
                
                $corretor->creci = $request->creci;
                $userMudar = true;
            }
        }

        if(isset($request->genero)){
            if($corretor->genero != $request->genero){
                $corretor->genero = $request->genero;
                $userMudar = true;
            }
        }
        
        if(isset($request->banco)){
            if($corretor->banco != $request->banco){
                $corretor->banco = $request->banco;
                $userMudar = true;
            }
        }
        
        if(isset($request->agencia)){
            if($corretor->agencia != $request->agencia){
                $corretor->agencia = $request->agencia;
                $userMudar = true;
            }
        }

        if(isset($request->tipo_conta)){
            if($corretor->tipo_conta != $request->tipo_conta){
                $corretor->tipo_conta = $request->tipo_conta;
                $userMudar = true;
            }
        }
        
        if(isset($request->pix)){
            if($corretor->pix != $request->pix){
                $corretor->pix = $request->pix;
                $userMudar = true;
            }
        }
        if(isset($request->biografia)){
            if($corretor->biografia != $request->biografia){
                $corretor->biografia = $request->biografia;
                $userMudar = true;
            }
        }
        
        if(isset($request->fotoCorretor)){
            $path = 'files';
            $arquivo = $request->fotoCorretor;
            $extencao = $arquivo->getClientOriginalExtension();
            if($extencao == "jpeg" || $extencao == "png" || $extencao == "jpg"){ 
                $nomeArquivo = uniqid(date('Ymdhis')).'.'.$extencao;
                $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);

                $corretor->url_foto = "storage/files/".$nomeArquivo;
                $userMudar = true;
            }
        }
        if($userMudar){
            $corretor->save();
        }
        if(isset($request->bairro)){
            $corretor->bairros()->detach();
            foreach($request->bairro as $bairro){
                $corretor->bairros()->attach($bairro);
            }
        }else if(isset($request->creci)){
            $corretor->bairros()->detach();
        }
        if(isset($request->regiao)){
            $corretor->regioes()->detach();
            foreach($request->regiao as $regiao){
                $corretor->regioes()->attach($regiao);
            }
        }else if(isset($request->creci)){
            $corretor->regiao()->detach();
        }


        return redirect()->route('dashboard.usuarios.index')->with('sweet-success', 'Usuário atualizado!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //controle para o propio usuario nao se editar
        if(Auth::user()->id == $id){
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Você não tem permissão para deletar sua própia conta');
        }
        
        $user = User::find($id);

        if($user){
            $user->roles()->detach();        
            $user->delete();
            return redirect()->route('dashboard.usuarios.index')->with('sweet-success', 'Usuário deletado!');
        }
        
        //User::destroy($id);
        return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Usuário não pode ser deletado!');
    }

    public function avatarProfile(Request $request)
    {        
        $validatedData = $request->validate([
            'arquivo' => 'required|image'
        ]);

        $user = User::find(Auth::id());

        if($user){

            $path = 'files';
            $arquivo = $request->arquivo;
            $extencao = $arquivo->getClientOriginalExtension();
            if($extencao == "jpeg" || $extencao == "png" || $extencao == "jpg"){ 
                $nomeArquivo = uniqid(date('Ymdhis')).'.'.$extencao;
                $uploadFiles = $arquivo->storeAs($path, $nomeArquivo);

                $caminho = "storage/files/".$nomeArquivo;

                if(Auth::user()->hasAnyRole('cliente')){
                    $usuario = Cliente::where('user_id',$user->id)->first();
                }
                if(Auth::user()->hasAnyRole('corretor')){
                    $usuario = Corretor::where('user_id',$user->id)->first();
                }
                
                $usuario->url_foto = $caminho;  
                  
                $usuario->save();
    
                return response()->json($usuario, 200);   
            }
            return response()->json(["errors" => "Arquivo com formato errado"], 404);              
        }

        return response()->json(["errors" => "Usuario nao encontrado"], 404); 

    }

    public function updateProfile(Request $request, $id){
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string',
            'perfil'=> 'required|integer'
        ]);

        //controle para o propio usuario se editar
        if(Auth::user()->id == $id){
            $user->name = $request->name;
            if ($request->nick) {
                $user->nick = $request->nick;
            }
            if ($request->descricao) {
                $user->descricao = $request->descricao;
            }
            if ($request->site) {
                $user->site = $request->site;
            }
            if ($request->endereco) {
                $user->endereco = $request->endereco;
            }
            if ($request->telefone) {
                $user->telefone = $request->telefone;
            }
            if ($request->genero) {
                $user->genero = $request->genero;
            }
            $tiporole = $request->perfil;
            if($tiporole == 3 || $tiporole == 4 || $tiporole == 5){
                $user->roles()->sync($tiporole);     
            }
            $user->save();
            $user->avatar = "storage/".$user->avatar;
            $user->roles;
            $token = explode(" ", $request->header('Authorization'));
            $user['token'] = $token[1];
            return response($user, 200);  
        }
        return response()->json(["errors" => "Sem permisão para atualizar"], 203);  

    }


    public function tipoConta()
    {
        
        $tipoconta = Role::where('name', '!=', 'admin')->where('name', '!=', 'usuario')->orWhereNull('name')->get();
        $tipoconta = Role::all();
        if(isset($tipoconta)){
            return response($tipoconta->toJson(),200);
        }

        return response()->json(["errors" => "Nenhum tipo de conta encontrado"], 404); 

    }


    //follower
    public function follower(Request $request){
        $id = Auth::id();
        $request->validate([
            'userid' => 'required|integer',
            'follower' => 'required|string'
        ]);
        if($id != $request->userid){
            if($request->follower == "follower"){
                $user = User::find($request->userid);
                if(isset($user)){
                    $user = User::find($id);
                    $user->users()->attach($request->userid);
                    return response()->json(["success" => "Usuario segindo"],200);
                }else{
                    return response()->json(["errors" => "Usuario a ser segido não encontrado"],404);
                }
            }else if($request->follower == "unfollower"){
                $follower = Follower::where('user_follower',$id)->where('user_followed',$request->userid)->get();
                if(isset($follower[0]['user_follower'])){
                    $user = User::find($follower[0]['user_follower']);
                    $user->users()->detach($request->userid);
                    return response()->json(["success" => "Seguir retirado"],200);
                }else{                    
                    return response()->json(["success" => "O usuario não está sendo seguido"],200);
                }
            }else{
                return response()->json(["errors" => "Intrução não capiturada"],404);
            }
        }else{
            return response()->json(["errors" => "Usuário não pode seguir a si próprio"],203);
        }

    } 
    
    //Usuario Busca
    public function usuarioBusca(Request $request){
        if(!is_null($request->texto)){
            if(strlen($request->texto) == 3){
                $user = User::where('name','like','%'.$request->texto.'%')->get();
                if(isset($user[0])){
                    return response()->json($user, 200);
                }else{
                    return response()->json(["errors" => "Nenhum unser encontrado."], 404);
                }
            }else{
                return response()->json(["errors" => "Parâmetro recebido não está no tamanho correto."], 400); 
            }
        }else{
            return response()->json(["errors" => "Parâmetro não recebido"], 400); 
        }
    }
    public function apresentaCorretores($id, Request $request){
        if($id == "all"){
            $corretores = Corretor::with('users')->get();
            if(isset($corretores[0])){
                return response()->json($corretores, 200);
            }
            return response()->json(["errors" => "Nenhum corretor encontrado."], 404);
        }else if($id == "busca"){
            $request->validate([
                'consulta' => 'required'
            ]);            
            $consulta = $request->consulta;
            $corretores = Corretor::with('users')->whereHas('users', function($e) use ($consulta){
                $e->where('name','like','%'.$consulta.'%');
            })->orWhere('creci',$request->consulta)->get();
            if(isset($corretores[0])){
                return response()->json($corretores, 200);
            }
            return response()->json(["errors" => "Nenhum corretor encontrado com os dados informados."], 404);
        }else{
            $request->validate([
                'consulta' => 'required'
            ]);  
            if($request->consulta == 'id'){
                $corretores = Corretor::with('users')->where('id',$id)->get();
                if(isset($corretores[0])){
                    return response()->json($corretores, 200);
                }
                return response()->json(["errors" => "Nenhum corretor encontrado com os dados informados."], 404);
            }else{
                return response()->json(["errors" => "Tipo da busca não informado"], 404);
            }

        }
        return response()->json(["errors" => "Tipo da busca não informado"], 404);
    }
    public function status($id, $status){
        $user = User::find($id);
        if(isset($user)){
            if($status == 0){
                $user->status = 0;
            }else if($status == 1){
                $user->status = 1;
            }
            $user->save();
            return view('usuarios.index')->with(['users' => User::paginate(20)]);
        }else{
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Não existe user com esse id');
        }
    }
    public function userEstado(Request $request){
        $cidades = Estado::with(['cidades' => function($e){
            $e->orderBy('name');
        }])->where("id",$request->id)->get();
        return response()->json($cidades,200);
    }
    public function userCidade(Request $request){
        $bairros = Cidade::with(['bairros' => function($e){
            $e->orderBy('name');
        },'regioes' => function($e){
            $e->orderBy('name');
        }])->where("id",$request->id)->get();
        return response()->json($bairros,200);
    }
    public function bairroCorretor(Request $request){
        $corretores = Bairro::with(['corretores.users'])->where('id',$request->id)->get();
        return response()->json($corretores,200);
    }
    public function preferidosInserir(Request $request){
        $request->validate([
            'produtoid' => 'required|integer|exists:produtos,id'
        ]);
        if(Auth::user()->hasAnyRole('cliente')){
            $preferido = Preferido::where('cliente_id_user', Auth::id())->where('produto_id', $request->produtoid)->first();
            if(!isset($preferido)){
                $user = User::find(Auth::id());
                $user->preferidos()->attach($request->produtoid);
                $user = User::with(['preferidos','preferidos.caracteristicas','preferidos.midias','preferidos.bairros', 'clientes'])->where('id',Auth::id())->first();
                return response()->json($user,200);
            }
            return response()->json('Produto já em preferidos',200);
        }else{
            return response()->json(["errors" => "Sem permisão para essa ação"], 203);  
        }
    }
    public function preferidosExcluir(Request $request){
        $request->validate([
            'produtoid' => 'required|integer|exists:produtos,id'
        ]);
        if(Auth::user()->hasAnyRole('cliente')){
            $preferido = Preferido::where('cliente_id_user', Auth::id())->where('produto_id', $request->produtoid)->first();
            if(isset($preferido)){
                $user = User::find(Auth::id());
                $user->preferidos()->detach($request->produtoid);
                $user = User::with(['preferidos','preferidos.caracteristicas','preferidos.midias','preferidos.bairros', 'clientes'])->where('id',Auth::id())->first();
                return response()->json($user,200);
            }
            return response()->json('Produto não está em preferidos',200);
        }else{
            return response()->json(["errors" => "Sem permisão para essa ação"], 203);  
        }
    }
    public function preferidosListar(){
        if(Auth::user()->hasAnyRole('cliente')){
            $user = User::with(['preferidos','preferidos.caracteristicas','preferidos.midias','preferidos.bairros', 'clientes'])->where('id',Auth::id())->first();
            return response()->json($user,200);
        }else{
            return response()->json(["errors" => "Sem permisão para essa ação"], 203);  
        }
    }
}
