<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $appends = [
        'statelike',
        'countlikes',
        'tipo',
        'post_imagens',
        'post_videos',
        'isAnuncio'
    ];
    
    public function getIsAnuncioAttribute() {
        if($this->attributes['tipo'] == 'anuncio'){
            return true;
        }else{
            return false;
        }
    }
    public function getStatelikeAttribute() {
        $id = Auth::id();
        $like = Like::where('user_id',$id)->where('post_id',$this->attributes['id'])->whereNull('comment_id')->get();
        if(count($like) > 0){
            return true;
        }else{
            return false;                   
        }
    }

    public function getCountlikesAttribute() {
        $like = Like::where('post_id',$this->attributes['id'])->whereNull('comment_id')->get();
        if(count($like) > 0){
            return count($like);
        }else{
            return 0;                    
        }
    }

    public function getTipoAttribute() {
        $videos = PostImage::where('post_id',$this->attributes['id'])->where('tipo','video')->get();
        if(count($videos) > 0){
            return "video";
        }else{
            return "imagem";                 
        }
    }

    public function getPostimagensAttribute() {
        $imagens = PostImage::where('post_id',$this->attributes['id'])->where('tipo','imagem')->get();
        if(count($imagens) > 0){
            $img = [];
            foreach ($imagens as $key => $imagem) {
                $img[] = $imagem->image;
            }
            return $img;
        }else{
            return false;                   
        }
    }

    public function getPostvideosAttribute() {
        $videos = PostImage::where('post_id',$this->attributes['id'])->where('tipo','video')->get();
        if(count($videos) > 0){
            $vid = [];
            foreach ($videos as $key => $video) {
                $vid[] = $video->image;
            }
            return $vid;
        }else{
            return false;                   
        }
    }
    
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'likes');
    }

    public function usersCommentsLike()
    {
        return $this->belongsToMany('App\Models\User', 'likes')->withPivot('comment_id');
    }

    protected $hidden = [
        'created_at','updated_at'
    ]; 
    
    function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
    
    function imagens() {
        return $this->hasMany('App\Models\PostImage');
    }

    function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag', 'tag_post');
    }
}
