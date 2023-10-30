<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $userMe = Auth::user();
        $users = User::where('id', '<>', $userMe->id)->get();
        
        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }
    public function show(User $id){
        return response()->json([
            'user' => $id
        ], Response::HTTP_OK);
    }
}
