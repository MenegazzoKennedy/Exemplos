<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Tipo;

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
            return view('home');
        }else if(Auth::user()->hasAnyRole('usuario')){
            //caso não seja admin do sistema
            Auth::logout();
            return redirect('/');
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function teste()
    {      
        $tiposProduto = Tipo::paginate(10);
        return view('imoveis-categoria.index')->with('tipo', $tiposProduto);        
    }
    
    public function construtora()
    {    
        return view('construtora.index',['nome' => Auth::user()->name]);

    }
}
