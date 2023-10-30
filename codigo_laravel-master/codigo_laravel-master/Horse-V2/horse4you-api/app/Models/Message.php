<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Auth;

class Message extends Model
{
    use HasFactory;

    protected $table = "messages";

    protected $fillable = [
        'from',
        'to',
        'content'
    ];
    protected $appends = [
        'user',
    ];


    public function messagesTo(){
        return $this->belongsTo('App\Models\User','to');
    }
    public function messagesFrom(){
        return $this->belongsTo('App\Models\User', 'from');
    }
    public function getUserAttribute() {
        $id = Auth::id();
        if($this->from == $id){
            return User::find($this->to);
        }else{
            return User::find($this->from);
        }
    }
}
