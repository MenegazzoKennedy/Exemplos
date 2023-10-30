<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        
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
        // $id = Auth::id();
        // $request->validate([
        //     'postid' => 'required|integer',
        //     'like' => 'required|string'
        // ]);
        // if($request->like == "like"){
        //     $post = Post::find($request->postid);
        //     $post->users()->attach($id);
        //     return $post;
        // }else{
        //     $like = Like::where('post_id',$request->postid)->where('user_id',$id)->get();
        //     if(isset($like)){
        //         $post = Post::find($like[0]["user_id"]);
        //         $post->users()->detach($id);
        //         return $post;
        //     }
        //     return response('deletado', 200);     
        // }    
        // return json_encode("teste");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
    public function show($id)
    {
        
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
    public function destroy($id)
    {   
    }

}
