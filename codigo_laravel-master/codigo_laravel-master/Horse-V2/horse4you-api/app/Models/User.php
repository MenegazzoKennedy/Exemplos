<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\APIPasswordResetNotfication;
use App\Models\PasswordResets;
use Illuminate\Support\Str;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Bairro;
use App\Models\Denuncia;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
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
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'privado',
        'status',
        'email_verified_at',
        'password',
        'remember_token',
        'estado_id',
        'cidade_id',
        'bairro_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'estado',
        'cidade',
        'bairro',
        'avatar', 
        'role',
        'quantiSeguidores'    
    ];

    public function getEstadoAttribute() {
        if (isset($this->attributes['estado_id'])) {
            $estadoName = Estado::where('id',$this->attributes['estado_id'])->first();
        }else{
            $estadoName = null;
        }        
        return $estadoName;
    }

    public function getCidadeAttribute() {
        if (isset($this->attributes['cidade_id'])) {
            $cidadeName = Cidade::where('id',$this->attributes['cidade_id'])->first();
        }else{
            $cidadeName = null;
        }  
        return $cidadeName;
    }
    
    public function getBairroAttribute() {
        if (isset($this->attributes['bairro_id'])) {
            $bairroName = Bairro::where('id',$this->attributes['bairro_id'])->first();
        }else{
            $bairroName = null;
        }  
        return $bairroName;
    }

    public function getAvatarAttribute() {
        if (isset($this->attributes['avatar'])) {
           $avatar = url("storage/".$this->attributes['avatar']);
        }else{
            $avatar = null;
        }
        return $avatar;
    }
    public function getRoleAttribute() {
        $role = DB::table('role_user')->where('user_id',$this->id)->where('role_id','>',2)->get();
        if(isset($role[0])){
            $roles = Role::find($role[0]->role_id);
            return $roles->name;
        }
        return "Indefinido";
    }
    public function getQuantiSeguidoresAttribute() {
        return DB::table('followers')->where('user_followed',$this->id)->count();
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
    
    public function hasAnyRoles($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    
    public function hasAnyRole($role){
        return null !== $this->roles()->where('name', $role)->first();
    }
    
    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
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
    public function usersMessageFrom()
    {
        return $this->hasMany('App\Models\Message', 'from');
    }
    public function seguir()
    {
        return $this->belongsToMany('App\Models\User', 'followers', 'user_followed', 'user_follower');
    }
    
    public function bloquear()
    {
        return $this->belongsToMany('App\Models\User', 'bloqueios', 'user_bloqueante', 'user_bloqueado');
    }
    public function bloqueio()
    {
        return $this->belongsToMany('App\Models\User', 'bloqueios', 'user_bloqueado', 'user_bloqueante');
    }
    
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

    public function tags(){
        return $this->belongsToMany('App\Models\Tag', 'tag_user')->withTimestamps();
    }
    
    public function denuncia(){
        return $this->belongsToMany('App\Models\Denuncia', 'tag_user')->withTimestamps();
    }
    public function denunciante(){
        return $this->belongsToMany('App\Models\Denuncia', 'id', 'id_user_denunciante')->withTimestamps();
    }
    public function denunciado(){
        return $this->belongsTo('App\Models\Denuncia', 'id_user_denunciado')->withTimestamps();
    }
}
