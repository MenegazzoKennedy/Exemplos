<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;
use App\Models\PostImage;
use Auth;

class AnuncioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::with(["user", "imagens", "comments","tags"])->where('tipo','anuncio')->orderBy('id', 'DESC')->paginate(20);
        return view('anuncios.index')->with('anuncios',$post); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('anuncios.add')->with('tags',Tag::all()); 
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
            'texto' => 'required|string',
            'midia' => 'required',
            'tags' => 'required|array'
        ]);
        if(isset($request->midia[0])){
            $post  = new Post();
            $post->texto = $request->texto;
            $post->status = 1;
            $post->user_id = Auth::user()->id;
            $post->tipo = 'anuncio';
            $post->save();
            
            foreach($request->midia as $midia){
                $arquivoValido = true;
                $extencao = $midia->getClientOriginalExtension();
                if($extencao == 'mp4'){
                    $arquivoValido = false;
                    $fileVideo = $midia;
                    $mime = $fileVideo->getMimeType();
                    //validação fotrmato video
                    if(
                        $mime == "video/x-flv" || 
                        $mime == "video/mp4" || 
                        $mime == "application/x-mpegURL" || 
                        $mime == "video/MP2T" || 
                        $mime == "video/3gpp" || 
                        $mime == "video/quicktime" || 
                        $mime == "video/x-msvideo" || 
                        $mime == "video/x-ms-wmv"
                        ){
                            $arquivoValido = true; 
                            $tipoUpload = "video";
                        }else{
                            $arquivoValido = false;
                        }
                    }
                }
                if($extencao = 'png' || $extencao = 'jpg' || $extencao = 'jpeg'){
                    $tipoUpload = "imagem";
                }
                if (($tipoUpload == "imagem" || $tipoUpload == "video") &&  $arquivoValido == true){
                    $name = $midia->getClientOriginalName();
                    $path = $midia->store('imagens/posts','public'); 

                //multifiles => https://www.tutsmake.com/laravel-8-multiple-file-upload-example/
                $i = true;
                $existe = __DIR__.'/../../../storage/app/public/'.$path;
                while($i){
                    if(file_exists($existe)){
                        $i = false;
                    }
                }

                $postImage= new PostImage();
                $postImage->post_id = $post->id;
                $postImage->image= $path;
                $postImage->tipo= $tipoUpload;
                $postImage->save();
                if($request->tags != null){ 
                    $idTags = [];   
                    foreach ($request->tags as $tag) {
                        $tag = strtolower(str_replace(" ","",str_replace("#","",$tag)));
                        //$tag = htmlentities($tag, ENT_QUOTES, 'UTF-8', true);
                        $tagHorse = Tag::where('tag', $tag)->first();                
                        if (isset($tagHorse)) {                    
                            array_push($idTags, $tagHorse->id);
                        }else{
                            $tagNew = new Tag();
                            $tagNew->tag = $tag;
                            $tagNew->save();
                            array_push($idTags, $tagNew->id);
                        }
                    }
                    $post->tags()->attach($idTags);   
                    $post->save();      
                }
            }
        }
        return redirect()->route('dashboard.anuncios.index')->with('sweet-success', 'Anúncio criado com suscesso!');
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
        $post = Post::find($id);
        if($post->status == 1){
            $post->status = 0;
        }else{
            $post->status = 1;
        }
        $post->save();
        return redirect()->route('dashboard.anuncios.index')->with('sweet-success', 'Status do anúncio atualizado!');
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
        //
    }
}
