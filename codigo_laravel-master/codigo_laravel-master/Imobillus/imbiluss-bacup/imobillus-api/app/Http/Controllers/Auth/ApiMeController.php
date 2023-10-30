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
    public function __invoke(Request $request){

        $user = $request->user();
        $id = $user->id;
        if ($request->input('user') != "me" && $user->id != $request->input('user')) {
            $user = User::find($request->input('user'));
            if(isset($user->id)){
                $follower = Follower::where("user_follower",$id)->where("user_followed",$request->input('user'))->get();
                if(isset($follower[0]->user_follower)){
                    $user['follower'] = true;
                }else{
                    $user['follower'] = false;
                }
            }else{
                $user = $request->user();
                if(Auth::user()->hasAnyRole('corretor')){
                    $bairros = Corretor::where('user_id', $user->id)->with('bairros','regioes')->get();
                    // return $bairros;
                    $user->bairros = $bairros[0]->bairros;
                    $user->regioes = $bairros[0]->regioes;
                }
            }
        }
        $user->roles;
        $avatar = $user->avatar;
        $user->avatar = url("storage/".$avatar);
        return response()->json($user, 200);  
        // return response()->json([
        //     'email' => $user->email,
        //     'nome' => $user->name
        // ]);        
    }
}
