<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Follower;
use App\Models\Corretor;
use App\Models\Bairro;
use App\Models\BairroCorretor;
use App\Models\Regiao;
use App\Models\CorretorRegiao;
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

        return view('usuarios.edit')->with(['usuario' => User::find($id), 'roles' => Role::all()]);
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
        //controle para o propio usuario nao se editar
        if(Auth::user()->id == $id){
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Você não tem permissão para editar sua própia conta');
        }

        $user = User::find($id);
        $user->roles()->sync($request->roles);

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

            //somente 1
            $name = $request->file('arquivo')->getClientOriginalName();
            $path = $request->file('arquivo')->store('imagens/perfil','public'); 

            $user->avatar = $path;  
              
            $user->save();

            return response()->json(["success" => "Foto atualizada"], 200);    
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
            $user->avatar = url("storage/".$user->avatar);
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
            $corretores = Corretor::all();
            if(isset($corretores[0])){
                $dados = [];
                $j = 0;
                foreach($corretores as $corretor){
                    $user = User::find($corretor->user_id);
                    $dados[$j]['nome'] = $user->name;
                    $dados[$j]['email'] = $user->email;
                    $dados[$j]['user_id'] = $user->id;
                    $dados[$j]['corretor_id'] = $corretor->id;
                    $dados[$j]['url_foto'] = $corretor->url_foto;
                    $dados[$j]['creci'] = $corretor->creci;
                    $dados[$j]['genero'] = $corretor->genero;
                    $dados[$j]['banco'] = $corretor->banco;
                    $dados[$j]['tipo_conta'] = $corretor->tipo_conta;
                    $dados[$j]['pix'] = $corretor->pix;
                    $dados[$j]['biografia'] = $corretor->biografia;
                    $bairrosCorretor = BairroCorretor::where('corretor_id',$corretor->id)->get();
                    if(isset($bairrosCorretor[0])){
                        $bairros = [];
                        $i = 0;
                        foreach($bairrosCorretor as $bairroCorretor){
                            $bairro = Bairro::find($bairroCorretor->bairro_id);
                            if($bairro){
                                $bairros[$i] = $bairro;
                                $i++;
                            }
                        }
                        $dados[$j]['bairros'] = $bairros;
                    }
                    $regioesCorretor = CorretorRegiao::where('corretor_id',$corretor->id)->get();
                    if(isset($regioesCorretor[0])){
                        $regioes = [];
                        $i = 0;
                        foreach($regioesCorretor as $regiaoCorretor){
                            $regiao = Bairro::find($regiaoCorretor->regiao_id);
                            if($regiao){
                                $regioes[$i] = $regiao;
                                $i++;
                            }
                        }
                        $dados[$j]['regioes'] = $regioes;
                    }
                    $j++;
                }
                return response()->json($dados, 200);
            }
            return response()->json(["errors" => "Nenhum corretor encontrado."], 404);
        }else{
            $request->validate([
               'tipo' => 'required|string'
            ]);
            if($request->tipo == 'creci' || $request->tipo == 'id'){
                $corretor = Corretor::where($request->tipo,$id)->first();
            }else{
                return response()->json(["errors" => "Tipo não corresponde."], 404);
            }
            if(isset($corretor)){
                $dados = [];
                $user = User::find($corretor->user_id);
                $dados['nome'] = $user->name;
                $dados['email'] = $user->email;
                $dados['user_id'] = $user->id;
                $dados['corretor_id'] = $corretor->id;
                $dados['url_foto'] = $corretor->url_foto;
                $dados['creci'] = $corretor->creci;
                $dados['genero'] = $corretor->genero;
                $dados['banco'] = $corretor->banco;
                $dados['tipo_conta'] = $corretor->tipo_conta;
                $dados['pix'] = $corretor->pix;
                $dados['biografia'] = $corretor->biografia;
                $bairrosCorretor = BairroCorretor::where('corretor_id',$id)->get();
                if(isset($bairrosCorretor)){
                    $bairros = [];
                    $i = 0;
                    foreach($bairrosCorretor as $bairroCorretor){
                        $bairro = Bairro::find($bairroCorretor->bairro_id);
                        if($bairro){
                            $bairros[$i] = $bairro;
                            $i++;
                        }
                    }
                    $dados['bairros'] = $bairros;
                }
                $regioesCorretor = CorretorRegiao::where('corretor_id',$id)->get();
                if(isset($regioesCorretor[0])){
                    $regioes = [];
                    $i = 0;
                    foreach($regioesCorretor as $regiaoCorretor){
                        $regiao = Bairro::find($regiaoCorretor->regiao_id);
                        if($regiao){
                            $regioes[$i] = $regiao;
                            $i++;
                        }
                    }
                    $dados['regioes'] = $regioes;
                }
                return response()->json($dados, 200);
            }
            return response()->json(["errors" => "Nenhum corretor encontrado com o id informado."], 404);
        }
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
}
