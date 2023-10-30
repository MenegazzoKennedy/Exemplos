<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Documento;
use App\Models\Negociacao;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NegociacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->term)) {
            $termo = $request->term;
            $tipo = $request->tipo;
            if ($tipo == "cliente") {
                $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->whereHas('cliente.user' , function($q) use ($termo) {
                    $q->where('name', 'Like', '%' . $termo . '%');
                })->paginate(20);
            }else if ($tipo == "imovel") {
                $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->whereHas('imovel', function($q) use ($termo){
                    $q->where("slug",'like','%'.$termo.'%')->orWhere("titulo",'like','%'.$termo.'%')->orWhere("descricao",'like','%'.$termo.'%');
                })->paginate(20);
            }else if ($tipo == "corretor") {
                $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->whereHas('corretor.users' , function($q) use ($termo) {
                    $q->where('name', 'Like', '%' . $termo . '%');
                })->paginate(20);
            }else{
                $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->paginate(20);  
            } 
        }else{
            $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->paginate(20);
        }

        
        return view('negociacao.index')->with('negociacao', $negociacao);  
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
        //dd($id);
        $negociacao = Negociacao::with(['cliente.user', 'corretor.users', 'imovel', 'documentos'])->where('id', $id)->get();       
        return view('negociacao.show')->with('negociacao', $negociacao);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('negociacao.edit')->with(['documento' => Documento::find($id)]);
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
        /*$request->validate([
            'descricao' => 'required|string',
        ]);
        $documento = Documento::find($id);
        if(isset($documento)){
            if($request->descricao != ""){
                $documento->descricao = $request->descricao;
            }
            $documento->save();
            return redirect()->route('dashboard.documento.index')->with('sweet-success', 'Documento atualizado');
        }else{
            return redirect()->route('documentos.index')->with('sweet-warning', 'Não existe documento com esse id');
        }*/
        return redirect()->route('dashboard.negociacao.index')->with('sweet-success', 'Negociação atualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
