<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use App\Models\Bloqueio;

class ApiMeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/me",
     *     summary="Dados User",
     *     description="Rota de consulta de dados do usuário",
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
    public function __invoke(Request $request){

        $user = $request->user();
        $id = $user->id;
        if ($request->input('user') != "me" && $user->id != $request->input('user')) {
            $user = User::find($request->input('user'));
            $user->numero_visualizacao  = $user->numero_visualizacao + 1;
            $user->save();
            if(isset($user->id)){
                $follower = Follower::where("user_follower",$id)->where("user_followed",$request->input('user'))->get();
                if(isset($follower[0]->user_follower)){
                    $user['follower'] = true;
                }else{
                    $user['follower'] = false;
                }
                $bloqueio = Bloqueio::where(['user_bloqueante' => $id, 'user_bloqueado' => $request->input('user')])->get();
                
                if(isset($bloqueio[0])){
                    $user['bloqueado'] = true;
                }else{
                    $user['bloqueado'] = false;
                }
            }else{
                $user = $request->user();
            }
        }
        $user->roles;
        $user['tags'] = $user->tags()->get();
        return response()->json($user, 200);       
    }
}
