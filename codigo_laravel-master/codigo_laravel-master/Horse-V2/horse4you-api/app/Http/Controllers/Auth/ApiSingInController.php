<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ApiSingInController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/singin",
     *     summary="Login bearer",
     *     description="Rota de login de usuário por meio de login e senha",
     *     operationId="authLogin",
     *     tags={"User"},
     *      security={ {"noauth": {} }},      
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),         
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "suporte@maiscode.com.br", "password": "123456789"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returna Token de acesso do usuario",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="{{TOKEN}}"),
     *          )
     *     )
     * )
     */

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

       
        if (!$token = auth('api')->attempt($request->only('email','password'))) {
            return response(['errors' => 'Acesso negado! Email ou senha não são válidos'], 400);
        }

        $token = compact('token');
        $user = User::where('email',$request->input('email'))->first();
        return response()->json([
            'id'=>$user->id,
            'email'=>$user->email,            
            'name'=>$user->name,
            'nick'=>$user->nick,
            'descricao'=>$user->descricao,
            'site'=>$user->site,            
            'endereco'=>$user->endereco,
            'numero'=>$user->numero,
            'cep'=>$user->cep,
            'telefone'=>$user->telefone,
            'genero'=>$user->genero,
            'aniversario'=>$user->aniversario,
            'avatar'=>$user->avatar,
            'tags' => $user->tags()->where('tags.status','=',1)->get(),
            'estado'=>$user->estado,
            'cidade'=>$user->cidade,
            'bairro'=>$user->bairro,
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,
            'token'=>$token['token']
        ], 201);
    }
}
