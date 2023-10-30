<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Visita;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = Visita::with(['produto','cliente','corretor'])->paginate(20);
        // return view('imovel.teste')->with('produtos', $visitas);  
        //return $visitas;
        return view('visitas.index')->with('visitas', $visitas);  
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
        $visita = Visita::find($id);
        if(isset($visita)){
            if($visita->status == 1){
                $visita->status = 0;
            }else if($visita->status == 0){
                $visita->status = 1;
            }
            $visita->save();
            return redirect()->route('dashboard.visita.index')->with('sweet-success', 'Status visita atualizado');
        }else{
            return redirect()->route('dashboard.visita.index')->with('sweet-warning', 'Não existe visita com esse id');
        }
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

    public function status($id)
    {
        /*$documento = Documento::find($id);
        if(isset($documento)){
            if($documento->status == 1){
                $documento->status = 0;
            }else if($documento->status == 0){
                $documento->status = 1;
            }
            $documento->save();
            return redirect()->route('dashboard.documento.index')->with('sweet-success', 'Status Documento atualizado');
        }else{
            return redirect()->route('dashboard.documento.index')->with('sweet-warning', 'Não existe documento com esse id');
        }*/
    }
}
