<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Role;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposProduto = Tipo::paginate(10);
        return view('imoveis-categoria.index')->with('tipo', $tiposProduto);    
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
        //
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
        return view('imoveis-categoria.edit')->with(['tipo' => Tipo::find($id)]);
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
        $tipo = Tipo::find($id);
        if(isset($tipo)){
            if($request->descricao != ""){
                $tipo->descricao = $request->descricao;
            }
            if($request->slug != ""){
                $tipo->slug = $request->slug;
            }
            $tipo->save();
            return redirect()->route('dashboard.categoria.index')->with('sweet-success', 'Categoria atualizada');
        }else{
            return redirect()->route('dashboard.categoria.index')->with('sweet-warning', 'Não existe categora com esse id');
        }
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
    public function status($id)
    {
        $tipo = Tipo::find($id);
        if(isset($tipo)){
            if($tipo->status == 1){
                $tipo->status = 0;
            }else if($tipo->status == 0){
                $tipo->status = 1;
            }
            $tipo->save();
            return redirect()->route('dashboard.categoria.index')->with('sweet-success', 'Status Categoria atualizada');
        }else{
            return redirect()->route('dashboard.categoria.index')->with('sweet-warning', 'Não existe categoria com esse id');
        }
    }
    public function categoriaNew() {
        return view('imoveis-categoria.new');   
    }
    public function categoriaInsercao(Request $request) {
        $request->validate([
            'descricao' => 'required|string',
            'slug' => 'required|string',
        ]);

        $tipo = new Tipo();
        $tipo->descricao = $request->descricao;
        $tipo->slug = $request->slug;
        $tipo->status = 1;
        $tipo->save();
        return redirect()->route('dashboard.categoria.index')->with('sweet-success', 'Categoria cadastrada');
    }
}
