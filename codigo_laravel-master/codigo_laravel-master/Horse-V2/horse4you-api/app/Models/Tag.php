<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $hidden = [
        'created_at','updated_at','status'
    ]; 
    
    /*protected $appends = [
        'total_user',
        'total_post'
    ]; */

    public function getTotalUserAttribute() {
        $totalTags = TagUser::where('tag_id',$this->attributes['id'])->count();       
        return $totalTags;
    }
    public function getTotalPostAttribute() {
        $totalTags = TagUser::where('tag_id',$this->attributes['id'])->count();       
        return 0;
    }

    public function user(){
        return $this->belongsToMany('App\Models\User','tag_user');
    }
    public function post(){
        return $this->belongsToMany('App\Models\Post','tag_post');
    }
}
