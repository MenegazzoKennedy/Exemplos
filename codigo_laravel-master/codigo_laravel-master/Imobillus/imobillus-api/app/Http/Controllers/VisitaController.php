<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Visita;
use App\Models\Corretor;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Bairro;
use App\Models\User;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = Visita::with(['produto','cliente.user','corretor.users'])->paginate(20);
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
            if(isset($visita->corretor_id) && !is_null($visita->corretor_id)){
                $corretor = Corretor::with('users')->where('id',$visita->corretor_id)->get();
            }else{
                $corretor = null;
            }
        }
        $corretores = Corretor::with('users')->get();
        $cliente = Cliente::with('user')->where('id',$visita->cliente_id)->get();
        $produto = Produto::find($visita->produto_id);
        $bairro = Bairro::with('cidade')->find($produto->bairro_id);
        return view('visitas.edit')->with(['visita' => $visita, 'corretor' => $corretor, 'corretores' => $corretores, 'cliente' => $cliente, 'produto' => $produto,'bairro' => $bairro]);
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
            'data' => 'date|after:tomorrow',
            'corretor'=>'required|integer'
        ]);
        $dataTime = $request->data." ".$request->hora;
        $visita = Visita::find($id);
        $mudar = false;
        $existeCor = false;
        if($visita->data != $dataTime){
            $visita->data = $dataTime;
            $mudar = true;
            $cliente = Cliente::find($visita->cliente_id);
            $user = User::find($cliente->user_id);
            $produto = Produto::find($visita->produto_id);
            $enviaEmail = $user->enviaEmailMudancaData($produto->titulo,$request->data,$request->hora);
            if(isset($request->corretor)){
                $corretor = Corretor::find($request->corretor);
                if(isset($corretor)){
                    $user = User::find($corretor->user_id);
                    $enviaEmail = $user->enviaEmailMudancaData($produto->titulo,$request->data,$request->hora);
                    $existeCor = true;
                }
            }
        }
        if(isset($request->corretor)){
            if($visita->corretor_id != $request->corretor){
                $visita->corretor_id = $request->corretor;
                if(!$existeCor){
                    $mudar = true;
                    $corretor = Corretor::find($request->corretor);
                    if(isset($corretor)){
                        $user = User::find($corretor->user_id);
                        $produto = Produto::find($visita->produto_id);
                        $existeCor = true;
                    }
                }
                if($existeCor){
                    $enviaEmail = $user->enviaEmailCorretor($produto->titulo);
                    $corretorName = $user->name;
                    $cliente = Cliente::find($visita->cliente_id);
                    $user = User::find($cliente->user_id);
                    $enviaEmail = $user->enviaEmailCliente($produto->titulo,$corretorName);
                }
            }
        }
        if($mudar){
            $visita->save();
        }
        // return view('imovel.teste')->with('produtos', $visitas);  
        //return $visitas;
        return redirect()->route('dashboard.visita.index');
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
}
