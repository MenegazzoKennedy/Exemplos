<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Follower;
use App\Models\Denuncia;
use App\Models\Post;
use App\Models\Comment;
use App\Models\DenunciaTipo;
use App\Models\Bairro;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
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
        if (Auth::user()->id == $id) {
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
        if (Auth::user()->id == $id) {
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
        if (Auth::user()->id == $id) {
            return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Você não tem permissão para deletar sua própia conta');
        }

        $user = User::find($id);

        if ($user) {
            $user->roles()->detach();
            $user->delete();
            return redirect()->route('dashboard.usuarios.index')->with('sweet-success', 'Usuário deletado!');
        }

        //User::destroy($id);
        return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Usuário não pode ser deletado!');
    }

    public function avatarProfile(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $user = User::find(Auth::id());

        if ($user) {

            //somente 1
            $name = $request->file('arquivo')->getClientOriginalName();
            $path = $request->file('arquivo')->store('imagens/perfil', 'public');

            $user->avatar = $path;

            $user->save();

            return response()->json(["success" => "Foto atualizada"], 200);
        }

        return response()->json(["errors" => "Usuario nao encontrado"], 404);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string',
            'perfil' => 'required|integer'
        ]);

        $key = "AHmy7Vvxgmu90kh0fyLcLjG4131u4D9n";
        $linkCidade = true;
        $linkEstado = true;
        $latlut = false;
        $link = 'http://www.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=';

        //controle para o propio usuario se editar
        if (Auth::user()->id == $id) {
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
            if ($request->cep) {
                $user->cep = $request->cep;
                $link = $link . "postalcode= " . $request->cep . ",";
                $latlut = true;
            }

            if ($request->bairro) {
                $user->bairro_id = $request->bairro;
                $bairro = Bairro::with('cidade', 'cidade.estado')->where('id', $request->bairro)->get();
                if (isset($bairro[0])) {
                    if (isset($bairro[0]->cidade)) {
                        $latlut = true;
                        $linkCidade = false;
                        $link = $link . "city = " . $bairro[0]->cidade->name . ",";
                        if (isset($bairro[0]->cidade->estado)) {
                            $linkEstado = false;
                            $link = $link . "County= " . $bairro[0]->cidade->estado->abbrev . ",";
                        }
                    }
                }
            }

            if ($request->cidade) {
                $user->cidade_id = $request->cidade;
                if ($linkCidade) {
                    $cidade = Cidade::with('estado')->where('id', $request->cidade)->get();
                    if (isset($cidade[0])) {
                        $latlut = true;
                        $linkCidade = false;
                        $link = $link . "city = " . $cidade[0]->name . ",";
                        if (isset($cidade[0]->estado)) {
                            $linkEstado = false;
                            $link = $link . "city = " . $cidade[0]->estado->abbrev . ",";
                        }
                    }
                }
            }

            if ($request->estado) {
                $user->estado_id = $request->estado;
                if ($linkEstado) {
                    $estado = Estado::where('id', $request->estado)->get();
                    if (isset($estado[0])) {
                        $latlut = true;
                        $linkEstado = false;
                        $link = $link . "County= " . $estado[0]->abbrev . ",";
                    }
                }
            }

            if ($request->endereco) {
                $user->endereco = $request->endereco;
            }
            if ($request->numero) {
                $user->numero = $request->numero;
            }
            if (isset($request->endereco) && isset($request->numero)) {
                $link = $link . "street = " . isset($request->numero) . " " . $request->endereco . ",";
                $latlut = true;
            } else if (isset($request->endereco)) {
                $link = $link . "street = " . $request->endereco . ",";
                $latlut = true;
            }
            if ($request->telefone) {
                $user->telefone = $request->telefone;
            }
            if ($request->genero) {
                $user->genero = $request->genero;
            }
            $tiporole = $request->perfil;
            if ($tiporole == 3 || $tiporole == 4 || $tiporole == 5) {
                $user->roles()->sync($tiporole);
            }

            if($request->tags != null){ 
                $idTags = [];   
                $user->tags()->detach();
                foreach ($request->tags as $tag) {
                    $tag = strtolower(str_replace(" ","",str_replace("#","",$tag)));
                    //$tag = htmlentities($tag, ENT_QUOTES, 'UTF-8', true);
                    $tagHorse = Tag::where('tag', $tag)->first();                
                    if (isset($tagHorse)) { 
                        if($tagHorse->status >= 0){                       
                            array_push($idTags, $tagHorse->id);
                        }
                    }else{
                        $tagNew = new Tag();
                        $tagNew->tag = $tag;
                        $tagNew->save();
                        array_push($idTags, $tagNew->id);
                    }
                }
                $user->tags()->attach($idTags);
                $user->save();  
            }
            if ($latlut) {
                $renultLatLong = Http::get($link);
                $renultLatLong['results'][0]['locations'][0]['latLng'];
                if (isset($renultLatLong['results'][0])) {
                    if (isset($renultLatLong['results'][0]['locations'][0])) {
                        $user->latitude = $renultLatLong['results'][0]['locations'][0]['latLng']['lat'];
                        $user->longitude = $renultLatLong['results'][0]['locations'][0]['latLng']['lng'];
                    }
                }
            }

            $user->save();
            //$user->avatar = url("storage/".$user->avatar);
            $user->roles;
            $token = explode(" ", $request->header('Authorization'));
            $user['tags'] = $user->tags()->where('tags.status','>=',0)->get(); 
            $user['token'] = $token[1];
            return response($user, 200);
        }
        return response()->json(["errors" => "Sem permisão para atualizar"], 203);
    }


    public function tipoConta()
    {

        $tipoconta = Role::where('name', '!=', 'admin')->where('name', '!=', 'usuario')->orWhereNull('name')->get();
        $tipoconta = Role::all();
        if (isset($tipoconta)) {
            return response($tipoconta->toJson(), 200);
        }

        return response()->json(["errors" => "Nenhum tipo de conta encontrado"], 404);
    }


    //follower
    public function follower(Request $request)
    {
        $id = Auth::id();
        $request->validate([
            'userid' => 'required|integer',
            'follower' => 'required|string'
        ]);
        if ($id != $request->userid) {
            if ($request->follower == "follower") {
                $user = User::find($request->userid);
                if (isset($user)) {
                    $user = User::find($id);
                    $user->users()->attach($request->userid);
                    return response()->json(["success" => "Usuario segindo"], 200);
                } else {
                    return response()->json(["errors" => "Usuario a ser segido não encontrado"], 404);
                }
            } else if ($request->follower == "unfollower") {
                $follower = Follower::where('user_follower', $id)->where('user_followed', $request->userid)->get();
                if (isset($follower[0]['user_follower'])) {
                    $user = User::find($follower[0]['user_follower']);
                    $user->users()->detach($request->userid);
                    return response()->json(["success" => "Seguir retirado"], 200);
                } else {
                    return response()->json(["success" => "O usuario não está sendo seguido"], 200);
                }
            } else {
                return response()->json(["errors" => "Intrução não capiturada"], 404);
            }
        } else {
            return response()->json(["errors" => "Usuário não pode seguir a si próprio"], 203);
        }
    }

    //Usuario Busca
    public function usuarioBusca(Request $request)
    {
        if (!is_null($request->texto)) {
            if (strlen($request->texto) == 3) {
                $user = User::where('name', 'like', '%' . $request->texto . '%')->get();
                if (isset($user[0])) {
                    return response()->json($user, 200);
                } else {
                    return response()->json(["errors" => "Nenhum unser encontrado."], 404);
                }
            } else {
                return response()->json(["errors" => "Parâmetro recebido não está no tamanho correto."], 400);
            }
        } else {
            return response()->json(["errors" => "Parâmetro não recebido"], 400);
        }
    }

    public function relatarDenuncia(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'tipo' => 'required|integer',
            'denuncia' => 'required|string',
            'categoria' => 'integer'
        ]);
        $idDenunciante = Auth::id();

        //tipo 1 => user 
        //tipo 2 => post 
        //tipo 3 => comentario 
        if ($request->tipo == 1) {
            if ($request->id != $idDenunciante) {
                if($idDenunciante != $request->id){
                    $user = User::find($request->id);
                    if (isset($user)) {
                        $denuncia = new Denuncia;
                        $denuncia->id_user_denunciante = $idDenunciante;
                        $denuncia->id_user_denunciado  = $request->id;
                    } else {
                        return response()->json(["errors" => "Usuario denunciado não encontrado"], 400);
                    }
                }else{
                    return response()->json(["errors" => "Usuario não pode se auto denunciar"], 400);
                }
            } else {
                return response()->json(["errors" => "Não pode se auto denunciar"], 400);
            }
        } else if ($request->tipo == 2) {
            $post = Post::find($request->id);
            if($idDenunciante != $post->user_id){
                if (isset($post)) {
                    $denuncia = new Denuncia;
                    $denuncia->id_user_denunciante = $idDenunciante;
                    $denuncia->id_post = $request->id;
                } else {
                    return response()->json(["errors" => "Post denunciado não encontrado"], 400);
                }
            }else{
                return response()->json(["errors" => "Não pode denunciar o próprio post"], 400);
            }
        } else if ($request->tipo == 3) {
            $comment = Comment::find($request->id);
            if($idDenunciante != $comment->user_id){
                if (isset($comment)) {
                    $denuncia = new Denuncia;
                    $denuncia->id_user_denunciante = $idDenunciante;
                    $denuncia->id_comentario  = $request->id;
                } else {
                    return response()->json(["errors" => "Comentario denunciado não encontrado"], 400);
                }
            }else{
                return response()->json(["errors" => "Não pode denunciar o próprio comentário"], 400);
            }
        } else {
            return response()->json(["errors" => "Tipo não encontrado"], 400);
        }
        if (isset($request->categoria)) {
            $denunciaCat = DenunciaTipo::find($request->categoria);
            if (isset($denunciaCat)) {
                $denuncia->categoria = $request->categoria;
            } else {
                $request->validate([
                    'descricao_categoria' => 'required|string',
                ]);
                $denuncia->descricao_categoria = $request->descricao_categoria;
            }
        } else if (isset($request->descricao_categoria)) {
            $request->validate([
                'descricao_categoria' => 'required|string',
            ]);
            $denuncia->descricao_categoria = $request->descricao_categoria;
        } else {
            return response()->json(["errors" => "Categoria e tipo da categoria não encontrados"], 400);
        }
        $denuncia->denuncia = $request->denuncia;
        $denuncia->save();
        return response()->json($denuncia, 200);
    }
    public function tiposDenuncia()
    {
        $denunciaCat = DenunciaTipo::where('status', 1)->get();
        return response()->json($denunciaCat, 200);
    }

    public function usuarioDistancia(Request $request)
    {
        $request->validate([
            'pagina' => 'required|integer|min:1',
            'is_first' => 'required|integer|min:0|max:1'
        ]);
        $distancia = $request->ultimaDistancia;
        $pagina = $request->pagina - 1;
        $off = 5 * $pagina; 
        $userMe = Auth::user();
        $data = [];
        if (!is_null($userMe->latitude) && !is_null($userMe->longitude)) {
            $request->validate([
                'ultimaDistancia' => 'required|integer'
            ]);
            $users = false;
            if($request->is_first == 1){ 
                $limit = 5;

                $query2 = DB::table('users AS usNot')->select('usNot.id')->join('denuncia','denuncia.id_user_denunciado', '=', 'usNot.id')->where('denuncia.status', '-1');

                $query3 = DB::table('users AS usNot2')->select('bloc.user_bloqueado')->join('bloqueios AS bloc','bloc.user_bloqueante', '=', 'usNot2.id')->where('usNot2.id',$userMe->id);

                $query4 = DB::table('users')->select('followers.user_followed')->join('followers', 'users.id', '=', 'followers.user_follower')->where('users.id',$userMe->id);

                while(!isset($users[0]) && $distancia < 6370){
                    
                    $users = User::selectRaw('* , (6371 * acos( cos( radians(' . $userMe->latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $userMe->longitude . ') ) + sin( radians(' . $userMe->latitude . ') ) * sin( radians( latitude ) ) ) ) as distancia')->with('users','roles')->withCount('users')->where(function ($query) use ($userMe, $distancia,$request) {
                        $query->whereIn('id',function($queryInterno) use ($userMe, $distancia,$request){
                            $queryInterno->select('useIn.id')->from('users AS useIn')->whereRaw('(6371 * acos( cos( radians(' . $userMe->latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $userMe->longitude . ') ) + sin( radians(' . $userMe->latitude . ') ) * sin( radians( latitude ) ) ) ) < '.$distancia)->where('id', '<>', $userMe->id);
                        });
                    })->where(function($query) use ($query2, $query3, $query4){
                        $query->whereNotIn('id',$query2)->whereNotIn('id',$query3)->whereNotIn('id',$query4);
                    })->where('id', '!=', $userMe->id)->orderBy('distancia','desc')->orderBy('users_count','asc')->limit($limit)->offset($off)->get();

                    $distancia = $distancia + 5;
                }
            }else{
                $request->validate([
                    'consulta' => 'required|string'
                ]);
                $limit = 20;

                $query2 = DB::table('users AS usNot')->select('usNot.id')->join('denuncia','denuncia.id_user_denunciado', '=', 'usNot.id')->where('denuncia.status', '-1');

                $query3 = DB::table('users AS usNot2')->select('bloc.user_bloqueado')->join('bloqueios AS bloc','bloc.user_bloqueante', '=', 'usNot2.id')->where('usNot2.id',$userMe->id);


                while(!isset($users[0]) && $distancia < 6370){
                    $users = User::selectRaw('* , (6371 * acos( cos( radians(' . $userMe->latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $userMe->longitude . ') ) + sin( radians(' . $userMe->latitude . ') ) * sin( radians( latitude ) ) ) ) as distancia')->with('users','roles')->withCount('users')->where(function ($query) use ($userMe, $distancia,$request) {
                        $query->whereIn('id',function($queryInterno) use ($userMe, $distancia,$request){
                            $queryInterno->select('useIn.id')->from('users AS useIn')->whereRaw('(6371 * acos( cos( radians(' . $userMe->latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $userMe->longitude . ') ) + sin( radians(' . $userMe->latitude . ') ) * sin( radians( latitude ) ) ) ) < '.$distancia)->where('id', '<>', $userMe->id)->where('name','like', '%'.$request->consulta.'%');
                        });
                    })->where(function($query) use ($query2, $query3){
                        $query->whereNotIn('id',$query2)->whereNotIn('id',$query3);
                    })->where('id', '!=', $userMe->id)->orderBy('distancia','desc')->orderBy('users_count','asc')->limit($limit)->offset($off)->get();
                    $distancia = $distancia + 5;
                }
            }
            
            if(isset($users[0])){
                $distancia = $distancia -5;
                $data['data'] = $users;
                $data['ultimaDistancia'] = $distancia;
            }else{ 
                $data['ultimaDistancia'] = $request->ultimaDistancia;                
            }
            $data['pagina'] = $pagina + 1;
            return response()->json($data, 200);
        }
        else{
            $users = false;
            if($request->is_first == 1){ 
                $limit = 5;
            }else{
                $limit = 20;
            }
            $users = User::with('users')->limit($limit)->get();
            // roberto@maiscode.com.br
            if(isset($users[0])){
                $data['data'] = $users->sortByDesc('quantiSeguidores');
            }
            $data['pagina'] = $pagina + 1;
            return response()->json($data, 200);
        }
        return response()->json(["errors" => "É necessario que você atualize o seu perfil"], 400);
    }

    public function reenvioSenhaUser($user_id){
        $user = User::find($user_id);
        if($user != null){
            $reset_link_sent = $user->sendPasswordRessetLink($user->id);
            return redirect()->route('dashboard.usuarios.index')->with('sweet-success', 'Foi enviado token de redefinição de senha para o e-mail do usuario.');
        }
        return redirect()->route('dashboard.usuarios.index')->with('sweet-warning', 'Usuario não encontrado');
    }

    public function bloquearUsuario($id, Request $request){
        $request->validate([
            'acao' => 'required|integer|min:0|max:1'
        ]);
        $idMe  =Auth::user()->id;
        if($idMe != $id){
            $userbloc = User::find($id);
            if(isset($userbloc)){
                $user = User::find($idMe);
                if($request->acao == 1){
                    $user->bloquear()->attach($id);
                }else{
                    $user->bloquear()->detach($id);
                }
                return response()->json(["success" => "Ação execultada"], 200);
            }
            return response()->json(["errors" => "Usuario não emcontrado"], 400);
        }else{
            return response()->json(["errors" => "Usuario não pode se bloquear"], 400);
        }
    }
    
    public function listaBloqueio(){
        $id = Auth::id();
        $user = User::where('id','=',$id)->with('bloquear')->get();
        return response()->json($user, 200);
    }
    
    public function seguirTag($id){
        $tag = Tag::find($id);
        if(isset($tag)){
            if($tag->status >= 0){    
                $user = User::find(Auth::id());
                $user->tags()->attach($id);
                return response()->json(["success" => "Tag sequida com successo!"], 200);
            }else{
                return response()->json(["errors" => "Tag indisponível!"], 404);
            }
        }else{
            return response()->json(["errors" => "Tag não encontrada!"], 404);
        }
    }
}
