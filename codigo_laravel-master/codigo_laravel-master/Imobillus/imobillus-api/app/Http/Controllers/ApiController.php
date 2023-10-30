<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Bairro;
use App\Models\Regiao;
use TymonJWTAuthExceptionsJWTException;
use JWTAuth;
use Illuminate\Support\Facades\Route;
use Auth;

class ApiController extends Controller
{   

    //validador
    public function teste(){
        $teste = [
            'msg' => 'API funcionando =]',
            'versao' => '1.0.0'
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
            'tipo'=>'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $tiporole = $request->tipo;
        if($tiporole == "cliente" || $tiporole == "corretor"){
            $user = new User([
                'name'=> $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)            
            ]);
            if($tiporole == "cliente"){
                $request->validate([
                    'cpf' => 'string',
                    'nascimento' => 'string',
                    'genero' => 'integer',
                    'corretor_id' => 'integer',
                    'telefone' => 'string',                    
                ]);
                    $cliente = new Cliente();
                    $dadosEnviados = false;
                    if(isset($request->cpf)){
                        $cliente->cpf = $request->cpf; 
                        $dadosEnviados = true;
                    }
                    if(isset($request->nascimento)){
                        $cliente->nascimento = $request->nascimento;
                        $dadosEnviados = true;
                    } 
                    if(isset($request->genero)){
                        $cliente->genero = $request->genero;
                        $dadosEnviados = true;
                    }
                    if(isset($request->url_foto)){
                        $cliente->url_foto = $request->url_foto;
                        $dadosEnviados = true;
                    }
                    if(isset($request->telefone)){
                        $cliente->telefone = $request->telefone;
                        $dadosEnviados = true;
                    }
                    if($request->corretor_id){
                        $corretor = Corretor::find($request->corretor_id);
                        if(isset($corretor)){
                            $cliente->corretor_id_preferido = $corretor->id;
                        }else{
                            return response()->json(["errors" => 'Corretor informado não encontrado'], 404);
                        }
                        if($corretor->genero){
                            $cliente->corretor_genero = $corretor->genero;
                        } 
                    }
                    if($dadosEnviados){
                        $user->save(); 
                        $cliente->user_id = $user->id;
                        $cliente->save();
                    }else{
                        return response()->json(["errors" => 'Dados necessarios não recebidos'], 406);
                    }
            }else if($tiporole == "corretor"){
                $request->validate([
                    'creci' => 'string',
                    'genero' => 'integer',
                    'bairros' => 'array',
                ]);   
                $corretor = new Corretor();
                $dadosEnviados = false;
                if(isset($request->genero)){
                    $corretor->genero = $request->genero; 
                    $dadosEnviados = true;
                }
                if(isset($request->url_foto)){
                    $corretor->url_foto = $request->url_foto;
                    $dadosEnviados = true;
                } 
                if(isset($request->creci)){
                    $corretor->creci = $request->creci;
                    $dadosEnviados = true;
                }
                if(isset($request->banco)){
                    $corretor->banco = $request->banco;
                    $dadosEnviados = true;
                }
                if(isset($request->agencia)){
                    $corretor->agencia = $request->agencia;
                    $dadosEnviados = true;
                }
                if(isset($request->pix)){
                    $corretor->pix = $request->pix;
                    $dadosEnviados = true;
                }
                if(isset($request->biografia)){
                    $corretor->biografia = $request->biografia;
                    $dadosEnviados = true;
                }
                if(isset($request->tipo_conta)){
                    $corretor->tipo_conta = $request->tipo_conta;
                    $dadosEnviados = true;
                }
                if($dadosEnviados){
                    $user->save(); 
                    $corretor->users()->associate($user->id);
                    $corretor->save();
                }else{
                    return response()->json(["errors" => 'Dados necessarios não recebidos'], 406);
                }

                if ($request->bairros) {
                    foreach($request->bairros as $bairro){
                        $ba = Bairro::where('id', $bairro)->get();
                        if(isset($ba[0])){
                            $corretor->bairros()->attach($bairro);
                        }
                    }
                }
                
                if ($request->regioes) {
                    foreach($request->regioes as $regiao){
                        $re = Regiao::where('id', $regiao)->get();
                        if(isset($re[0])){
                            $corretor->regioes()->attach($regiao);
                        }
                    }
                }    
            }

                   
            //libera tipo de usuario padrao
            $role = Role::select('id')->where('name',$tiporole)->first();
            $user->roles()->sync($role);
            
            
            //event(new EventNovoRegistro($user));

            //gera token
            $input = $request->only('email', 'password');
            $jwt_token = null;

            
            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalido Email ou Password',
                ], Response::HTTP_UNAUTHORIZED);
            }
            if (!$token = auth('api')->attempt($request->only('email','password'))) {
                return response(['errors' => 'Acesso negado! Email ou senha não são válidos'], 400);
            }
            $token = compact('token');
            if($tiporole == "cliente"){
                return response()->json([
                    'id'=>$user->id,
                    'email'=>$user->email,            
                    'name'=>$user->name,
                    'telefone'=>$cliente->telefone,
                    'genero'=>$cliente->genero,
                    'nascimento'=>$cliente->nascimento,
                    'corretor_id_preferido'=>$cliente->corretor_id_preferido,
                    'cpf'=>$cliente->cpf,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'cliente_id'=>$cliente->id,
                    'token'=>$token['token'],
                ], 201);
            }else if($tiporole == "corretor"){
                return response()->json([
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'creci'=>$corretor->creci,
                    'genero'=>$corretor->genero,
                    'token'=>$token['token'],
                    'url_foto'=>$corretor->url_foto,
                    'banco'=>$corretor->banco,
                    'agencia'=>$corretor->agencia,
                    'tipo_conta'=>$corretor->tipo_conta,
                    'pix'=>$corretor->pix,
                    'biografia'=>$corretor->biografia,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                ], 201);
            }
        }else{
            return response()->json(["errors" => 'Você não possui permição para criar esse usuario'], 203);
        }
    }
    
}
