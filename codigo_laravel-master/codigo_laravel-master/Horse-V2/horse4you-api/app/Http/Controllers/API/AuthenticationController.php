<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResets;

class AuthenticationController extends Controller
{
    public function sendPasswordResetToken(Request $request){
        $request->validate([
            "email" => "required|email",
        ]);
        $data = $request;
        
        $user = User::where("email", $data["email"])->first();
        if($user != null){
            $reset_link_sent = $user->sendPasswordRessetLink($user->id);
            if($reset_link_sent){
                return response()->json("um token de redefinição de senha foi enviado para o seu e-mail, por favor, a página de redefinição de senha para redefinir sua senha", 200);
            }
            return response()->json(["errors" => $user->getErrorMessage()], 404);
        }
        return response()->json(["errors" => 'Email não encontrado'], 404);
    }
    public function validatePasswordResetToken(Request $data){
        $resetToken = PasswordResets::where("token_signature", hash('md5',$data['password_reset_code']))->where("token_type", 10)->first();
        if($resetToken == null || $resetToken->count() <= 0){
            return response()->json(["errors" => 'Código de redefinição de senha inválido'], 404);
        }
        if(now()->greaterThan($resetToken->expires_at)){
            return response()->json(["errors" => 'O código de redefinição de senha fornecido expirou'], 404);
        }
        $resetToken = $resetToken->getResetIdentifierCode();
        if($resetToken){
            PasswordResets::where("token_signature", hash('md5',$data['password_reset_code']))->where("token_type", 10)->update(["expires_at" => now()]);
            return response()->json(['token' => $resetToken], 200);
        }else{
            return response()->json(["errors" =>$resetToken], 404);
        }
    }
    public function setNewAccountPassword(Request $data){
        $data->validate([
            "password_token" => "required|string|max:10",
            "password" => "required|string|max:45",
        ]);
        
        $VerifToken = PasswordResets::where("token_signature", hash('md5',$data['password_token']))->where("used_token", 2)->get();
        if(!isset($VerifToken[0]) || $VerifToken->count() <= 0){
            return response()->json(["errors" => 'Código de redefinição de senha inválido'], 404);
        }
       $user = User::find($VerifToken[0]->user_id);
        if(!isset($user) || $user->count() <= 0){
            return response()->json(["errors" =>'O token não corresponde a nenhum usuário existente'], 404);
        }
        if(now()->greaterThan($VerifToken[0]->expires_at)){
            return response()->json(["errors" => 'O código de redefinição de senha fornecido expirou'], 404);
        }
        $new_password = Hash::make($data["password"]);
        $user->password = $new_password;
        $user->save();
        PasswordResets::where("token_signature", hash('md5',$data['password_token']))->where("used_token", 2)->update(["expires_at" => now()]);
        return response()->json($user, 200);
    }
}
