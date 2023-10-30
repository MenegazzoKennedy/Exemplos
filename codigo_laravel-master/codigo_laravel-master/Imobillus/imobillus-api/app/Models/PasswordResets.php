<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordResets extends Model
{
    use HasFactory;
    
    protected $fillable = [];
    
    protected $table = 'password_resets';
    protected $hidden = [
        'created_at','updated_at'
    ]; 
    public function genResetCode(){
        return Str::random(10);
    }
    public function getResetIdentifierCode(){
        $token = $this->genResetCode();
        try{
            $apiToken = new PasswordResets();
            $apiToken->user_id = $this->user_id; 
            $apiToken->token_signature = hash('md5', $token); 
            $apiToken->token_type = $this->id; 
            $apiToken->used_token = 2; 
            $apiToken->expires_at = now()->addMinutes(30); 
            $apiToken->save(); 
            return $token;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    } 
    public function PASSWORD_RESET_TOKEN(){
        
    }
}
