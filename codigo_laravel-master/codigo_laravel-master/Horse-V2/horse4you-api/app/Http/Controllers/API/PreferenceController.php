<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preference;
use Auth;

class PreferenceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //$preference = Preference::all();

        $preference = Preference::where('user_id', '=', Auth::id())->orderBy('tag_id', 'ASC')->get();
       
        if (isset($preference)) {         
            return response()->json($preference, 200);           
        }
        return response()->json(["errors" => "Preference não encontrado"], 404);
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
            'id_tag' => 'required|int'
        ]);

        $preference = new Preference();        
        $preference->user_id = Auth::id();
        $preference->tag_id = $request->input('id_tag');
        $preference->save();

        return response()->json($preference, 200);  
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
    public function show(Request $request,$id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$preference = Preference::find($id);
        
        if (isset($preference)) {
            $preference->delete();
            return response('Preference deletada', 200);       
        }else{
            return response('Preference não encontrado', 404);
        }*/
    }

}
