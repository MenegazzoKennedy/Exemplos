<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Auth;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $paginate = 15;

        $id = Auth::id();
        if($request->input('iduser') == "me"){
            //lista meus posts
            $post = Post::with(["user", "imagens", "comments","tags" => function($query){
                $query->where('status', '>=', 0);
            }])->whereNotIn('posts.user_id',function($query) use($id){
                $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
            })->whereNotIn('posts.user_id',function($query) use($id){
                $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
            })->where('status',1)->where('user_id',$id)->orderBy('id', 'DESC')->paginate($paginate);
        }else if(!is_null($request->input('iduser'))){
            //lista ex: usuario id = 1
            $post = Post::with(["user", "imagens", "comments","tags" => function($query){
                $query->where('status', '>=', 0);
            }])->whereNotIn('posts.user_id',function($query) use($id){
                $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
            })->whereNotIn('posts.user_id',function($query) use($id){
                $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
            })->where('status',1)->where('user_id',$request->input('iduser'))->orderBy('id', 'DESC')->paginate($paginate);
        }else{  
            //timeline
            
            //https://qastack.com.br/programming/30522528/how-to-merge-two-eloquent-collections
            
            $query11 = DB::table('posts')->select('id')->where('tipo', 'anuncio');

            $query1 = DB::table('posts')->select('posts.id')->join('tag_post AS tp','tp.post_id', '=', 'posts.id')->join('tag_user AS tu','tp.tag_id', '=', 'tu.tag_id')->join('users AS us1','us1.id', '=', 'tu.user_id')->join('tags', function($query){
                $query->on('tags.id', '=', 'tp.tag_id');
                $query->on('tags.id', '=', 'tu.tag_id');
            })->where('us1.id',$id)->groupBy('posts.id');

            $query2 = DB::table('posts')->select('posts.id')->join('followers AS fo','fo.user_followed', '=', 'posts.user_id')->join('users AS us2','us2.id','=', 'fo.user_follower')->where('us2.id',$id)->groupBy('posts.id');

            $query1outro = DB::table('posts')->select('posts.id')->join('tag_post AS tp','tp.post_id', '<>', 'posts.id')->join('tag_user AS tu','tp.tag_id', '<>', 'tu.tag_id')->join('users AS us1','us1.id', '<>', 'tu.user_id')->join('tags', function($query){
                $query->on('tags.id', '<>', 'tp.tag_id');
                $query->on('tags.id', '<>', 'tu.tag_id');
            })->where('us1.id',$id)->groupBy('posts.id');

            $query2outro = DB::table('posts')->select('posts.id')->join('followers AS fo','fo.user_followed', '<>', 'posts.user_id')->join('users AS us2','us2.id','<>', 'fo.user_follower')->where('us2.id',$id)->groupBy('posts.id');

            $query3 = DB::table('posts')->select('posts.id')->join('bloqueios AS bloc1','bloc1.user_bloqueado', '=', 'posts.user_id')->join('users AS us3','us3.id', '=', 'bloc1.user_bloqueante')->whereNotIn('posts.id',$query11)->where('us3.id',$id)->groupBy('posts.id');

            $query4 = DB::table('posts')->select('posts.id')->join("bloqueios AS bloc2",'bloc2.user_bloqueante', '=', 'posts.user_id')->join('users AS us4', 'us4.id', '=', 'bloc2.user_bloqueado')->whereNotIn('posts.id',$query11)->where('us4.id', $id)->groupBy('posts.id');
            $query5 = DB::table('posts')->select('posts.id')->join('denuncia AS den1','den1.id_user_denunciado', '=', 'posts.user_id')->join('users AS us5','us5.id', '=', 'den1.id_user_denunciante')->where('us5.id', $id)->whereNotIn('posts.id',$query11)->groupBy('posts.id');
            
            $query6 = DB::table('posts')->select('posts.id')->join('denuncia AS den2','den2.id_post', '=', 'posts.id')->join('users AS us6', 'us6.id', '=', 'den2.id_user_denunciante')->where('us6.id', $id)->whereNotIn('posts.id',$query11)->groupBy('posts.id');
            
            $query7 = DB::table('comments')->select('comments.id')->join('denuncia AS den3','den3.id_comentario', '=', 'comments.id')->join('users AS us7', 'us7.id', '=', 'den3.id_user_denunciante')->where('us7.id', $id)->groupBy('comments.id');
            
            $query8 = DB::table('posts')->select('posts.id')->join('denuncia AS den4','den4.id_post', '=', 'posts.id')->where('den4.status', '=', -1)->whereNotIn('posts.id',$query11)->groupBy('posts.id');

            $query9 = DB::table('comments')->select('comments.id')->join('denuncia AS den5','den5.id_comentario', '=', 'comments.id')->where('den5.status', '=', -1)->whereNotIn('posts.id',$query11)->groupBy('comments.id');

            $query10 = DB::table('posts')->select('posts.id')->join('users','users.id', '=', 'posts.user_id')->join('denuncia AS den6','den6.id_user_denunciado', '=', 'users.id')->where('den6.status', '=', -1)->whereNotIn('posts.id',$query11)->groupBy('posts.id');

            $post1 = Post::with(["user", "imagens", "comments" => function($query) use ($query7){
                $query->whereNotIn('id', $query7);
            },"tags"])->where(function($query) use ($query1,$query2,$query11,$id){
                $query->whereIn('id',$query1)->orWhereIn('id',$query2)->orWhereIn('id',$query11)->orWhere('user_id',$id);
            })->where(function($query) use ($query3,$query4,$query5,$query6,$query8,$query9,$query10){
                $query->whereNotIn('id',$query3)->whereNotIn('id',$query4)->whereNotIn('id',$query5)->whereNotIn('id',$query6)->whereNotIn('id',$query8)->whereNotIn('id',$query9)->whereNotIn('id',$query10);
            })->where('posts.status',1)->groupBy('posts.id')->orderBy('posts.created_at','DESC');
            
            $post = Post::with(["user", "imagens", "comments" => function($query) use ($query7){
                $query->whereNotIn('id', $query7);
            },"tags"])->where(function($query) use ($query1outro,$query2outro,$id){
                $query->whereIn('id',$query1outro)->orWhereIn('id',$query2outro)->orWhere('user_id',$id);
            })->where(function($query) use ($query3,$query4,$query5,$query6,$query8,$query9,$query10){
                $query->whereNotIn('id',$query3)->whereNotIn('id',$query4)->whereNotIn('id',$query5)->whereNotIn('id',$query6)->whereNotIn('id',$query8)->whereNotIn('id',$query9)->whereNotIn('id',$query10);
            })->where('posts.status',1)->groupBy('posts.id')->orderBy('posts.created_at','DESC')->union($post1)->orderBy('created_at', 'desc')->paginate(17);
            
        }

        if (isset($post)) {        
            return response()->json($post, 200);
        }
        return response()->json(["errors" => "Post não encontrado"], 404);
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
       $request->validate([
            'texto' => 'required|string'
        ]);
        
        $post = new Post();
        $post->user_id = Auth::id();
        $post->texto = $request->input('texto');
        $post->tipo = "";
        $post->status = 1;
        $post->save();

        if($request->tags != null){ 
            $idTags = [];   
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
            $post->tags()->attach($idTags);   
            $post->save(); 
            $post['tags'] = $post->tags()->get();      
        }
        
        return response()->json($post, 201);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
    public function show(Request $request,$id)
    {
        $idUser = Auth::id();
        $post = Post::with(["user", "imagens", "comments", "tags"=> function($query){
            $query->where('status', '>=', 0);
        }])->whereNotIn('posts.user_id',function($query) use($idUser){
            $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$idUser);
        })->whereNotIn('posts.user_id',function($query) use($idUser){
            $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$idUser);
        })->where('status',1)->where('id',$id)->orderBy('id', 'DESC')->get();
        
        if (isset($post[0])) {
            return response()->json($post, 200);        
        }
        return response()->json(["errors" => "Post não encontrado"], 404);
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
        $request->validate([
            'texto' => 'required|string'
        ]);
        
        $post = Post::find($id);
        if (isset($post)) {
            $post->texto = $request->input('texto');            
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
            $post->save();
            $post['tags'] = $post->tags()->where('tags.status','>=',0)->get();  

            return response()->json($post, 200);   
        }
        return response()->json(["errors" => "Post não encontrado"], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (isset($post)) {
            // $post->delete();
            $id = Auth::id(); 
            if( $id == $post->user_id){
                $post->status = 0;
                $post->tags()->detach();   
                $post->save();
                return response()->json(["success" => "Deletado"], 200);  
            }else{
                return response()->json(["errors" => "O usuario não é dono deste post"], 203);  
            }
                
        }else{
            return response()->json(["errors" => "Post não encontrado"], 404);
        }
    }


    //postLike
    public function likePost(Request $request)
    {
        $id = Auth::id();
        $request->validate([
            'postid' => 'required|integer',
            'like' => 'required|string'
        ]);
        $post = Post::with('users')->where('id','=',$request->postid)->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
        })->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
        })->where('status','=',1)->get();
        if(isset($post[0])){
            if($request->like == "like"){
                if(isset($post)){
                    $post[0]->users()->attach($id);
                    return response()->json(["success" => "Post recebeu like"],200);
                }
            }else if($request->like == "unlike"){
                $like = Like::where('post_id',$request->postid)->where('user_id',$id)->get();
                if(isset($like[0]["user_id"])){
                    $post[0]->users()->wherePivotNull('comment_id')->detach($id);
                    return response()->json(["success" => "Like retirado"], 200);     
                }
                return response()->json(["success" => "Post não recebeu o like"], 200);   
            }    
            return response()->json(["errors" => "Instrução não capturada"], 203);
        }else{
            return response()->json(["errors" => "Post não encontrado"], 404); 
        }
    }

    public function postPreferencia(){ 
        // $user = User::find(Auth::id());
        $id = Auth::id();
        $post = Post::with(["user", "imagens", "comments"])->whereHas("user",function($e) use ($id){
            $e->where('id',$id);
        })->where('status',1)->orderBy('id', 'DESC')->get();

        return response()->json($post, 200);  
    }

}
