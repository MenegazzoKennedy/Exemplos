<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use App\Models\Corretor;
use Auth;

class ApiMeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/me",
     *     summary="Dados User",
     *     description="Rota de consulta de dados do usuÃ¡rio",
     *     operationId="authMe",
     *     tags={"User"},       
     *     @OA\Response(
     *         response=200,
     *         description="Returna Token de acesso do usuario",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="{{TOKEN}}"),
     *          )
     *     )
     * )
     */
    public function __invoke(){;
        if(Auth::user()->hasAnyRole('corretor')){
            $user = User::with(['corretores.bairros','corretores.regioes'])->where('id', Auth::id())->first();
        }else if(Auth::user()->hasAnyRole('cliente')){
            $user = User::with(['clientes'])->where('id',Auth::id())->first();
        }
        return response()->json($user, 200);  
        // return response()->json([
        //     'email' => $user->email,
        //     'nome' => $user->name
        // ]);        
    }
}
