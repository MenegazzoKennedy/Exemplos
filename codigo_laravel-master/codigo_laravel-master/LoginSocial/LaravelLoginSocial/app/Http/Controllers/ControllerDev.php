<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerDev extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    public function user(Request $request){
        return $request->user();
    }
}
