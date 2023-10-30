<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Auth;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Tag >= 0 ativo / -1 inativo

        $tag = DB::select('SELECT  *, SUM(total) AS totalFinal FROM (SELECT  ta1.*, COUNT(tu.tag_id) AS total FROM tags AS ta1 INNER JOIN tag_user AS tu ON tu.tag_id = ta1.id GROUP BY tu.tag_id UNION SELECT  ta2.*, COUNT(tp.tag_id) AS total FROM tags AS ta2 INNER JOIN tag_post AS tp ON tp.tag_id = ta2.id GROUP BY tp.tag_id) AS tab WHERE status >= 0 GROUP BY tab.id ORDER BY tab.total DESC LIMIT 10;');
       
        if (isset($tag)) {             
            return response()->json($tag, 200);       
        }
        return response()->json(["errors" => "Tag não encontrada"], 301);
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
            'tag' => 'required|string'
        ]);
        
        $tag = new Tag();
        $tag->tag = $request->input('tag');
        $tag->save();
        
        return response()->json($tag, 200);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
    public function show(Request $request,$id)
    {
        $tag = Tag::find($id);
        if (isset($tag)) {        
            return response()->json($tag, 200);  
        }
        return response()->json(["errors" => "Tag não encontrada"], 301);
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
            'tag' => 'required|string'
        ]);
        
        $tag = Tag::find($id);
        if (isset($tag)) {
            $tag->tag = $request->input('tag');
            $tag->save();
            return response()->json($tag, 200);  
        }
        return response()->json(["errors" => "Tag não encontrada"], 301);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (isset($tag)) {
            $tag->delete();
            return response()->json(["success" => "Tag deletada"], 200);       
        }else{
            return response()->json(["errors" => "Tag não encontrada"], 301);
        }
    }


}
