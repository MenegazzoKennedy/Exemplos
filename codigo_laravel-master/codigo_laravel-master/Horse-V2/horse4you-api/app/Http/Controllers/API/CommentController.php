<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Auth;

class CommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $request->validate([
            'idpost' => 'required|integer'
        ]);
        $id = Auth::id();
        $post = Post::where('id','=',$request->idpost)->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
        })->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
        })->where('status','=',1)->get();
        if(isset($post[0])){
            $comments = Comment::where('post_id',$request->idpost)->get();
            if(isset($comments)){
                $i = 0;
                $dadosUsers = [];
                foreach($comments as $comment){
                    $user = User::find($comment->user_id);
                    $dadosUsers['name'] = $user->name;
                    $dadosUsers['nick'] = $user->nick;
                    $dadosUsers['avatar'] = $user->avatar;
                    $comments[$i]['dadosuser'] = $dadosUsers;
                    $i ++;
                }
                return response()->json($comments, 200);
            }else{
                return response()->json(["errors" => "Não exite comentarios para esse post"], 204);
            }
        }else{
            return response()->json(["errors" => "Post não encontrado"], 404); 
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
        $request->validate([
            'texto' => 'required|string',
            'idpost' => 'required|integer'
        ]);
        $id = Auth::id();
        $post = Post::where('id','=',$request->idpost)->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
        })->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
        })->where('status','=',1)->get();
        if(isset($post[0])){
            $comment = new Comment();
            $comment->texto = $request->input('texto');
            $commentId = $request->idpost;
            $comment->post_id = $commentId;
            if ($request->input('post_reply')) {
                $comment->reply_id = $request->input('post_reply');
            }       
            $comment->user_id = Auth::id();
            $comment->save();
            
            return response()->json($comment, 201);
        }else{
            return response()->json(["errors" => "Post não encontrado"], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
    public function show($id)
    {
        if(isset($id)){
            $idUser = Auth::id();
            $post = Post::where('id','=',$id)->whereNotIn('posts.user_id',function($query) use($idUser){
                $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$idUser);
            })->whereNotIn('posts.user_id',function($query) use($idUser){
                $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$idUser);
            })->where('status','=',1)->get();

            if(isset($post[0])){
                $comments = Comment::where('post_id',$id)->whereNull('reply_id')->get();
                if(isset($comments)){
                    return response()->json($comments, 200);
                }else{
                    return response()->json(["errors" => "Não exite comentarios para esse post"], 204);
                }
            }else{
                return response()->json(["errors" => "Post não encontrado"], 404); 
            }
        }else{
            return response()->json(["errors" => "Não exite comentarios para esse post"], 212);
        } 
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idcoment)
    {
        $comment = Comment::find($idcoment);
        if(isset($comment)){
            $idusuario = Auth::id();
            if($comment->user_id == Auth::id()){
                $comment->delete();
                return response()->json(["success" => "Deletado"], 200);
            }else{
                return response()->json(["errors" => "Usuario não corresponde ao comentario"], 203);
            }
        }else {
            return response()->json(["errors" => "Comentario não encontrado"], 404); 
        }   
        
    }

    //commentsLike
    public function likeComments(Request $request)
    {
        $id = Auth::id();
        $request->validate([
            'postid' => 'required|integer',
            'commentid' => 'required|integer',
            'like' => 'required|string'
        ]);
        $post = Post::where('id','=',$request->postid)->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueado from bloqueios')->where('user_bloqueante','=',$id);
        })->whereNotIn('posts.user_id',function($query) use($id){
            $query->selectRaw('user_bloqueante from bloqueios')->where('user_bloqueado','=',$id);
        })->where('status','=',1)->get();
        if(isset($post[0])){
            if($request->like == "like"){
                $comment = Comment::find($request->commentid);
                if(isset($comment)){
                    $comment->users()->attach($id,['post_id' => $request->postid]);
                    return response()->json(["success" => "Comentário recebeu like"],200);
                }else{
                    return response()->json(["errors" => "Comentário não encontrado"], 404); 
                }
            }else if($request->like == "unlike"){
                $like = Like::where('post_id',$request->postid)->where('comment_id',$request->commentid)->where('user_id',$id)->get();
                if(isset($like[0]["user_id"])){
                    $comment = Comment::find($request->commentid);
                    if(isset($comment)){
                        $comment->users()->detach($id,['post_id' => $request->postid]);
                        return response()->json(["success" => "Like comentário retirado"], 200);  
                    }   
                }
                return response()->json(["success" => "Comentário não recebeu o like"], 200);   
            }
        }else{
           return response()->json(["errors" => "Post não encontrado"], 404); 
        } 
        return response()->json(["errors" => "Instrução não capturada"], 203);
    }

    
}   
