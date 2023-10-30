<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index(){
	 	 return view('welcome');
    }     
	public function userValida(Request $request){
		return $request->user();
	}
	public function common_room(Request $request){
		return true;
	}
}
?>