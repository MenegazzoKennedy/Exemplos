<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Tag;


class TagCrmController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        if(Auth::user()->hasAnyRole('admin')){
            $tagsApp = Tag::paginate(10);
            $tagsApp->each(function ($items) {
                $items->append('TotalUser');
                $items->append('TotalPost');
            });
            return view('tags.index')->with('tags', $tagsApp);
        }else if(Auth::user()->hasAnyRole('usuario')){
            //caso não seja admin do sistema
            Auth::logout();
            return redirect('/');
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function showStatus($status)
    {        
        if(Auth::user()->hasAnyRole('admin')){
            if ($status == 'pendente') {
                $status = 1;
            }else if ($status == 'ativo') {
                $status = 0;
            }else if ($status == 'inativo') {
                $status = -1;
            }else{
                return redirect()->route('dashboard.tags.index')->with('sweet-warning', 'Algo deu errado');
            }

            $tagsApp = Tag::where('status', $status)->paginate(10);
            $tagsApp->each(function ($items) {
                $items->append('TotalUser');
                $items->append('TotalPost');
            });
            return view('tags.index')->with('tags', $tagsApp);
        }else if(Auth::user()->hasAnyRole('usuario')){
            //caso não seja admin do sistema
            Auth::logout();
            return redirect('/');
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function status($id, $newstatus)
    {
        $tag = Tag::find($id);
        if(isset($tag)){
            if($newstatus == 1){
                $tag->status = $newstatus;
            }else if($newstatus == 0){
                $tag->status = $newstatus;
            }else if($newstatus == -1){
                $tag->status = $newstatus;
            }else{
                return redirect()->route('dashboard.tags.index')->with('sweet-warning', 'Algo deu errado');
            }
            $tag->save();
            return redirect()->route('dashboard.tags.index')->with('sweet-success', 'Status Tag atualizada');
        }else{
            return redirect()->route('dashboard.tags.index')->with('sweet-warning', 'Não existe Tag com esse id');
        }
    }

}
