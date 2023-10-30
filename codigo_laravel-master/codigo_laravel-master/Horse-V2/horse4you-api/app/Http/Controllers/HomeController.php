<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        if(Auth::user()->hasAnyRole('admin')){
            $ldate = date('Y-m-d H:i:s');

            $user =  User::orderBy('numero_visualizacao','DESC')->orderBy('created_at', 'asc')->limit(10)->get();
            
            $tagsPost = DB::table('tags as tg')->selectRaw('tg.*, COUNT(tp.tag_id) AS numBerLikesTP')->join('tag_post AS tp','tp.tag_id', '=', 'tg.id')->groupBy('tg.id')->orderBy('numBerLikesTP','DESC')->limit(10)->get();
            
            $tagsUser = DB::table('tags as tg')->selectRaw('tg.*, COUNT(tu.tag_id) AS numBerLikesTU')->join('tag_user AS tu','tu.tag_id', '=', 'tg.id')->groupBy('tg.id')->orderBy('numBerLikesTU','DESC')->limit(10)->get();

            $usersPostLike = DB::table('users')->selectRaw('users.*, COUNT(users.id) AS numBerLikes')->join('posts AS p','p.user_id', '=', 'users.id')->join('likes AS li','li.post_id', '=', 'p.id')->groupBy('users.id')->orderBy('numBerLikes', 'DESC')->limit(10)->get();
            
            $quantidadeMes = DB::table('users')->selectRaw('COUNT(*) as crecimento, DATE_SUB("'.$ldate.'", INTERVAL 1 MONTH) as datas')->where('created_at','>=', 'datas')->get();
            
            $quantidadeMesAnteior = DB::table('users')->selectRaw('COUNT(*) as crecimento, DATE_SUB("'.$ldate.'", INTERVAL 2 MONTH) as datasAnterior, DATE_SUB("'.$ldate.'", INTERVAL 1 MONTH) as datas')->where('created_at','>=', 'datasAnterior')->where('created_at','<=', 'datas')->get();
            
            $quantidadeMesAntes = DB::table('users')->selectRaw('COUNT(*) as crecimento, DATE_SUB("'.$ldate.'", INTERVAL 2 MONTH) as datas')->where('created_at','<=', 'datas')->get();

            return view('home')->with(['numero_visualizacao' => $user, 'tagPost' => $tagsPost, 'tagUser' => $tagsUser, 'usersPostLike' => $usersPostLike, 'quantidadeMes' => $quantidadeMes, 'quantidadeMesAnterior' => $quantidadeMesAnteior, 'quantidadeMesAntes' => $quantidadeMesAntes]);
        }else if(Auth::user()->hasAnyRole('usuario')){
            //caso não seja admin do sistema
            Auth::logout();
            return redirect('/');
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

}
