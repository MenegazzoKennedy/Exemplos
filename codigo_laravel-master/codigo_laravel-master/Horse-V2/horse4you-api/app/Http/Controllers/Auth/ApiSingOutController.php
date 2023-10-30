<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiSingOutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/singout",
     *     summary="Logout",
     *     description="Rota de logout",
     *     operationId="authMe",
     *     tags={"User"},    
     *     @OA\Response(
     *         response=200,
     *         description="Returna logout usuario",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Logout sucesso"),
     *          )
     *     )
     * )
     */
    
    public function __invoke(){
        auth('api')->logout();
        return response()->json(["success" => "Deslogado com sucesso!"], 200);  
    }
}
