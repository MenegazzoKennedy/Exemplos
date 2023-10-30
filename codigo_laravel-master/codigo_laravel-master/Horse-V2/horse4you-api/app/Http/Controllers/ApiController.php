<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use TymonJWTAuthExceptionsJWTException;
use JWTAuth;

class ApiController extends Controller
{   

    //validador
    public function teste(){
        $teste = [
            'msg' => 'API funcionando =]',
            'revisao' => '03-08-2021',
            'versao' => '1.0.58'
        ];

        return response()->json($teste, 200);  
    }

    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Sign Up",
     *     description="Rota de criação de usuario por meio do formulário",
     *     operationId="authRegister",
     *     tags={"User"},
     *      security={ {"noauth": {} }},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *     @OA\Parameter(
     *         name="password_confirmation",
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
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string"
     *                 ),
     *                 example={"name": "Marcus", "email": "suporte@maiscode.com.br", "password": "123456789", "password_confirmation": "123456789"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Returns Usuario criado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="email", type="string", example="suporte@maiscode.com.br"),
     *              @OA\Property(property="name", type="string", example="Marcus"),
     *              @OA\Property(property="token", type="string", example="{{TOKEN}}"),
     *          )
     *     )
     * )
     */
    public function register(Request $request) {
        
        $request->validate([
            'name' => 'required|string',
            'aniversario' => 'required|string',
            'perfil'=>'required|integer',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $tiporole = $request->perfil;
        if($tiporole != 3 && $tiporole != 4 && $tiporole != 5){
            return response()->json(["errors" => "Tipo de perfil do usuario não existe"], 203);
        }
        $user = new User([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)            
        ]);
        $user->aniversario = $request->aniversario;
        /*$user = new User([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => str_random(60)
        ]);*/

        $user->save();

        //libera tipo de usuario padrao
        $role = Role::select('id')->where('id',$tiporole)->first();
        $user->roles()->sync($role);
        
        //event(new EventNovoRegistro($user));

        if($request->tags != null){
            foreach($request->tags as $tag){
                $user->tags()->attach($tag);
            }
            $user->save();
        }

        //gera token
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalido Email ou Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'id'=>$user->id,
            'email'=>$user->email,            
            'name'=>$user->name,
            'perfil'=>$tiporole,
            'aniversario'=>$user->aniversario,
            'tags'=>$user->tags()->get(),
            'token'=>$jwt_token,
        ], 201);
    }
}
