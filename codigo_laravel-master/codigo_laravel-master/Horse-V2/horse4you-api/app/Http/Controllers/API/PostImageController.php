<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostImage;
use App\Models\Post;
use Intervention\Image\ImageManagerStatic as Image;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessarVideo;
use FFMpeg;
use Auth;

class PostImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //
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
        $arquivoValido = true;

        $validatedData = $request->validate([            
            'post_id' => 'required|integer',
            'tipo' => 'required|string'
        ]);
        
        $post  = Post::find($request->input('post_id'));

        $tipoUpload = $request->input('tipo');
        if(isset($post)){
            $myId = Auth::id();
            if($post->user_id == $myId){
                if ($tipoUpload == "video"){
                    $request->validate([
                        'arquivo' => 'required|max:64000|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
                    ]);
                    $arquivoValido = false;
                    $fileVideo = $request->file('arquivo');
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
                    }else{
                        $arquivoValido = false;
                    }

                }
                if($tipoUpload == "imagem"){
                    $request->validate([
                        'arquivo' => 'required|image|max:64000|mimes:jpeg,png,jpg'
                    ]);
                }
                if (($tipoUpload == "imagem" || $tipoUpload == "video") &&  $arquivoValido == true){
                    $name = $request->file('arquivo')->getClientOriginalName();
                    $path = $request->file('arquivo')->store('imagens/posts/originais','public'); 
                    //multifiles => https://www.tutsmake.com/laravel-8-multiple-file-upload-example/
                    $i = true;
                    $existe = __DIR__.'/../../../../storage/app/public/'.$path;
                    while($i){
                        if(file_exists($existe)){
                            $i = false;
                        }
                    }
                    /*redimencionar images => http://image.intervention.io/api/resize*/
                    if($tipoUpload == "imagem"){
                        $img = Image::make($request->file('arquivo'))->resize(400, 400, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save($existe);
                    }
                    $postImage= new PostImage();
                    $postImage->post_id = $request->input('post_id');
                    $postImage->image= $path;
                    $postImage->tipo= $tipoUpload;
                    $postImage->save();
                    if($tipoUpload == "video"){
                        ProcessarVideo::dispatch($postImage->id);
                    }
                    return response()->json($postImage, 200);   
                }else{
                    return response()->json(["errors" => "Formato de arquivo não permitido"], 301);
                }
            }else{
                return response()->json(["errors" => "Não pode adcionar um video em um posts que não é criador "], 203);
            }
        }else{
            return response()->json(["errors" => "Post não encontrado"], 404);
        }
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
        //
    }

}
