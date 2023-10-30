<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Corretor;

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
        if($user->hasAnyRole('cliente')){
            $cliente = Cliente::with(['users'])->where('user_id',$user->id)->first();
            return response()->json([
                'cliente_id'=>$cliente->id,
                'id'=>$user->id,
                'email'=>$user->email,            
                'name'=>$user->name,
                'telefone'=>$cliente->telefone,
                'genero'=>$cliente->genero,
                'nascimento'=>$cliente->nascimento,
                'corretor_id_preferido'=>$cliente->corretor_id_preferido,
                'cpf'=>$cliente->cpf,
                'url_foto'=>$cliente->url_foto,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
                'token'=>$token['token']
            ], 201);
        }else if($user->hasAnyRole('corretor')){
            $corretor = Corretor::with(['users'])->where('user_id',$user->id)->first();
            return response()->json([
                'corretor_id'=>$corretor->id,
                'id'=>$user->id,
                'email'=>$user->email,            
                'name'=>$user->name,
                'genero'=>$corretor->genero,
                'creci'=>$corretor->creci,
                'url_foto'=>$corretor->url_foto,
                'banco'=>$corretor->banco,
                'agencia'=>$corretor->agencia,
                'tipo_conta'=>$corretor->tipo_conta,
                'pix'=>$corretor->pix,
                'biografia'=>$corretor->biografia,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
                'token'=>$token['token']
            ], 201);
        }else{
            return response()->json([
                'id'=>$user->id,
                'email'=>$user->email,            
                'name'=>$user->name,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
                'token'=>$token['token']
            ], 201);
        }
    }
}
