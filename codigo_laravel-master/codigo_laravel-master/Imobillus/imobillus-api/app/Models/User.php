<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\APIPasswordResetNotfication;
use App\Notifications\DisparaCorretor;
use App\Notifications\DisparaCliente;
use App\Notifications\DisparaMudancaData;
use App\Notifications\DisparaGestor;
use Illuminate\Support\Str;
use App\Models\PasswordResets;
use App\Models\Corretor;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'privado',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function genResetCode(){
        return Str::random(10);
    }
    public function sendPasswordRessetLink($id){
        do{
            $user = $this;
            $token = $this->genResetCode();
            $signature = hash('md5', $token);
            $exists = PasswordResets::where([
                ["user_id", $user->id],
                ["token_signature", $signature]
            ])->exists();
        }while($exists);

        try{
            $user->notify(new APIPasswordResetNotfication($token));
            $apiToken = new PasswordResets();
            $apiToken->user_id = $user->id; 
            $apiToken->token_signature = $signature; 
            $apiToken->used_token = 1; 
            $apiToken->expires_at = now()->addMinutes(30); 
            $apiToken->save(); 
            return $apiToken;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }

    public function enviaEmailCorretor($nameProduto){
        try{
            $corretor = $this;
            $corretor->notify(new DisparaCorretor($nameProduto, $corretor->name));
            return $corretor;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }
    
    public function enviaEmailCliente($nameProduto,$corretor){
        try{
            $cliente = $this;
            $cliente->notify(new DisparaCliente($nameProduto, $cliente->name,$corretor));
            return $corretor;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }
    
    public function enviaEmailMudancaData($nameProduto,$data,$hora){
        try{
            $corretor = $this;
            $corretor->notify(new DisparaMudancaData($nameProduto, $corretor->name,$data,$hora));
            return $corretor;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }
    
    public function enviaEmailGestor($nameProduto){
        try{
            $gestor = $this;
            $gestor->notify(new DisparaGestor($nameProduto, $gestor->name));
            return $gestor;
        }catch(Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }

    public function hasAnyRoles($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasAnyRole($role){
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    function preferences() {
        //esta pedido pertence a um usuario
        return $this->belongsTo("App\Models\Preference");
    }

    // Many to Many
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'likes');
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'followers', 'user_follower', 'user_followed');
    }


    public function clientes(){
        return $this->hasMany('App\Models\Cliente');
    }
    public function corretores(){
        return $this->hasMany('App\Models\Corretor');
    }
    
    public function preferidos(){
        return $this->belongsToMany('App\Models\Produto', 'preferidos', 'cliente_id_user', 'produto_id');
    }
}
