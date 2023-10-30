<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $hidden = [];
    
    protected $appends = [
        'user',
        'reply',
        'statelikecomment',
        'countlikescomment'
    ];

    public function getUserAttribute() {
        $userComments = User::select(DB::raw('id, name, nick, avatar'))->where('id', $this->attributes['user_id'])->get();
        return $userComments;
    }

    public function getReplyAttribute() {
        $replyComments = Comment::where('reply_id', $this->attributes['id'])->get();
        return $replyComments;
    }

    public function getStatelikecommentAttribute() {
        $id = Auth::id();
        $like = Like::where('user_id',$id)->where('comment_id',$this->attributes['id'])->get();
        if(count($like) > 0){
            return true;
        }else{
            return false;                   
        }
    }

    public function getCountlikescommentAttribute() {
        $like = Like::where('comment_id',$this->attributes['id'])->get();
        if(count($like) > 0){
            return count($like);
        }else{
            return 0;                    
        }
    }


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'likes')->withPivot('post_id');
    }

    function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    function post() {
        return $this->belongsTo('App\Models\Post','post_id');
    }
}
