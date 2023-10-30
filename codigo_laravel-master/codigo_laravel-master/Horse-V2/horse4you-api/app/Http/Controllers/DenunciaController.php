<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use App\Models\DenunciaTipo;
use App\Models\Post;
use App\Models\Comment;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->tipo)){
            $denuncia = Denuncia::paginate(20);
            $ded['data'] = $denuncia; 
            $ded['tipo'] = 'Usuario / Post / Comentario';
            return view('denuncias.index')->with('denuncias', $ded);
        }else if($request->tipo == 'usuario'){
            $denuncia = Denuncia::where('id_user_denunciado','>',0)->paginate(20);
            $ded['data'] = $denuncia; 
            $ded['tipo'] = 'Usuario';
            return view('denuncias.index')->with('denuncias', $ded);
        }else if($request->tipo == 'post'){
            $denuncia = Denuncia::where('id_post','>',0)->paginate(20);
            $ded['data'] = $denuncia; 
            $ded['tipo'] = 'Post';
            return view('denuncias.index')->with('denuncias', $ded);
        }else if($request->tipo == 'comentario'){
            $denuncia = Denuncia::where('id_comentario','>',0)->paginate(20);
            $ded['data'] = $denuncia; 
            $ded['tipo'] = 'Comentario';
            return view('denuncias.index')->with('denuncias', $ded);
        }else{
            return redirect()->route('dashboard.denuncia.index')->with('sweet-warning', 'Tipo de consuita não recebido!');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('denuncias.add');
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
            'descricao' => 'required|string|unique:App\Models\DenunciaTipo,descricao'
        ]);
        $tipo = new DenunciaTipo;
        $tipo->descricao = $request->descricao;
        $tipo->save();

        return redirect()->route('dashboard.tipoDenuncia')->with('sweet-success', 'Tipo de denuncia adicionado!');
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
        $denuncia = Denuncia::find($id);
        $denunciado = "";
        if (isset($denuncia->denunciadoArray[0]->user) && !isset($denuncia->denunciadoArray[0]->post)) {
            $denunciado = Denuncia::where('id_post', '=', $denuncia->denunciadoArray[0]->id)->where('id', '!=', $id)->get();
        } elseif (isset($denuncia->denunciadoArray[0]->user) && isset($denuncia->denunciadoArray[0]->post)) {
            $denunciado = Denuncia::where('id_comentario', $denuncia->denunciadoArray[0]->id)->get();
        } else {
            $denunciado = Denuncia::where('id_user_denunciado', '=', $denuncia->denunciadoArray[0]->id)->where('id', '!=', $id)->get();
        }
        return view('denuncias.edit')->with(['denuncia' => $denuncia, 'denunciado' => $denunciado]);
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
            "status" => 'required|integer|max:1|min:-1'
        ]);
        $denuncia = Denuncia::find($id);
        if ($request->status != 0 && $denuncia->status != $request->status) {
            $denuncia->status = $request->status;
            $denuncia->save();
            if (isset($denuncia->id_post)) {
                $post = Post::find($denuncia->id_post);
                $post->status = $denuncia->status;
                $post->save();
            } else if (isset($denuncia->id_comentario)) {
                $comment = Comment::find($denuncia->id_comentario);
                $comment->status = $denuncia->status;
                $comment->save();
            }
        }
        return redirect()->route('dashboard.denuncia.index')->with('sweet-success', 'Denuncia moderada com suscesso!');
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

    public function indexTipo()
    {
        return view('denuncias.indexTipo')->with('tipoDenuncias', DenunciaTipo::paginate(20));
    }
    public function editTipo($id)
    {
        return view('denuncias.editTipo')->with('tipoDenuncia', DenunciaTipo::find($id));
    }
    public function updateTipo(Request $request, $id)
    {
        $request->validate([
            "status" => 'integer|max:1|min:0',
            "descricao" => 'string'
        ]);
        $denuncia = DenunciaTipo::find($id);
        $salvar = false;
        if (isset($request->status)) {
            if ($denuncia->status != $request->status) {
                $denuncia->status = $request->status;
                $salvar = true;
            }
        }
        if (isset($request->descricao)) {
            $denuncia->descricao = $request->descricao;
            $salvar = true;
        }
        if ($salvar) {
            $denuncia->save();
        }

        return redirect()->route('dashboard.tipoDenuncia')->with('sweet-success', 'Tipo de denuncia atualizada com suscesso!');
    }
}
