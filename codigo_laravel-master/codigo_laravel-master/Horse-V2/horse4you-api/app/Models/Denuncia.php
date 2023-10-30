<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\DenunciaTipo;

class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'denuncia';

    protected $hidden = [
        'created_at','updated_at'
    ]; 

    protected $appends = [
        'denunciado',
        'categoriaAppend',
        'denuciador',
        'tipoDenunciado',
        'denunciadoArray',
    ];

    public function getcategoriaAppendAttribute() {
        $denunciaTipo = DenunciaTipo::find($this->categoria);
        if(isset($denunciaTipo)){
            return $denunciaTipo->descricao;
        }
        return "Tipo não criado = ".$this->descricao_categoria;
    }
    public function getdenuciadorAttribute() {
        $user = User::find($this->id_user_denunciante);
        return $user->id." - ".$user->name;
    }
    public function gettipoDenunciadoAttribute() {
        if(isset($this->id_user_denunciado)){
            return "Usuario Denunciado: ";
        }else if(isset($this->id_post )){
            return "Post Denunciado: ";
        }else if(isset($this->id_comentario)){
            return "Comentario Denunciado: ";
        }
    }
    public function getdenunciadoArrayAttribute() {
        if(isset($this->id_user_denunciado)){
            $user = User::where('id',$this->id_user_denunciado)->get();
            return $user;
        }else if(isset($this->id_post )){
            $post = Post::where('id',$this->id_post)->with('user')->get();
            return $post;
        }else if(isset($this->id_comentario)){
            $comment = Comment::where('id',$this->id_comentario)->with(['user', 'post'])->get();
            return $comment;
        }
    }
    public function getdenunciadoAttribute() {
        if(isset($this->id_user_denunciado)){
            $user = User::find($this->id_user_denunciado);
            return $user->id." - ".$user->name;
        }else if(isset($this->id_post )){
            $post = Post::find($this->id_post);
            return $post->id." - ".$post->texto;
        }else if(isset($this->id_comentario)){
            $comment = Comment::find($this->id_comentario);
            return $comment->id." - ".$comment->texto;
        }
    }
}
