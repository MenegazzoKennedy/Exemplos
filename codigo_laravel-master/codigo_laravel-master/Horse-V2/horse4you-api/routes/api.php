<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ApiSingInController;
use App\Http\Controllers\Auth\ApiSingOutController;
use App\Http\Controllers\Auth\ApiMeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\PostImageController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\PreferenceController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\LocalidadeController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\API\MessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('validarapi', [ApiController::class, 'teste']);
Route::get('clear', [ConfigController::class, 'clearRouteApi']);

Route::post('user/register', [ApiController::class, 'register']);
Route::group(['prefix' => 'auth'], function () {
    Route::post('singin', ApiSingInController::class);
    Route::post('singout', ApiSingOutController::class);    
    Route::middleware('auth:api')->group(function() {
        Route::post('me', ApiMeController::class);
    });
});

Route::prefix('/user')->group(function() {
    // Esta rota leva o código alfanumérico 6 recebido do e-mail, garante que é um código válido
    Route::post('/reset-password-token', [AuthenticationController::class, 'validatePasswordResetToken'])->name('api-reset-password-token');
    // Esta rota leva um e-mail, valida se o e-mail existe e envia 6 códigos alfanuméricos para o e-mail do usuário
    Route::post('/forgot-password', [AuthenticationController::class, 'sendPasswordResetToken'])->name('api-reset-password');
    // Esta rota pega a nova senha e senha de confirmação, e redefine a senha
    Route::post('/new-password', [AuthenticationController::class, 'setNewAccountPassword'])->name('new-account-password');
});

//API APP
Route::middleware('auth:api')->group(function() {
    //User
    Route::post('profile/update/{id}', [UserController::class, 'updateProfile']);
    Route::post('profile/avatar/update', [UserController::class, 'avatarProfile']);
    Route::get('profile/tipoconta', [UserController::class, 'tipoConta']);
    Route::post('users', [UserController::class, 'usuarioSolo']);
    Route::post('users/busca', [UserController::class, 'usuarioBusca']);
    //Post Imagem
    Route::post('posts/upload/file', [PostImageController::class, 'store']);
    //Preference
    Route::apiResource('preferences', PreferenceController::class);
    //rotas post
    Route::apiResource('posts', PostController::class);
    //Comments
    Route::post('comments/likes', [CommentController::class, 'likeComments']);
    Route::post('comments/show', [CommentController::class, 'indexReply']);
    Route::apiResource('comments', CommentController::class);    
    //Likes
    Route::post('likes', [PostController::class, 'likePost']);
    //followers
    Route::post('followers', [UserController::class, 'follower']);

    //rotas post por preferencia
    Route::get('preferencia', [PostController::class, 'postPreferencia']);
    
    //rotas de denuncia
    Route::post('relata/denuncia/', [UserController::class, 'relatarDenuncia']);
    Route::get('tipos/denuncia', [UserController::class, 'tiposDenuncia']);
    
    //rotas usuario por distancia
    Route::post('usuario/distancia', [UserController::class, 'usuarioDistancia']);
    
    //bloquear usuario
    Route::post('usuario/bloqueio/{id}', [UserController::class, 'bloquearUsuario']);
    Route::post('usuario/listar/bloqueio', [UserController::class, 'listaBloqueio']);  

    //user seguir tag
    Route::post('usuario/seguir/tag/{id}', [UserController::class, 'seguirTag']);


    
    Route::get('/mensages/{user}', [MessageController::class, 'listMessages']);
    Route::post('/mensages/store', [MessageController::class, 'store']);
    Route::post('/mensages/ultimas', [MessageController::class, 'ultimaMensagem']);

    Route::get('/remencionarVideo/{id}', [PostImageController::class, 'remencionarVideo']);
    
});


Route::prefix('localidades')->group(function() {
    Route::get("/cidades/{id}", [LocalidadeController::class, 'consultaCidades']);
    Route::get("/estados", [LocalidadeController::class, 'consultaEstados']);
    Route::get("/{id_cidade}/locaisBairros", [LocalidadeController::class, 'consultaLocaisBairrosCidades']);
});

//Tag Provisório
Route::apiResource('tags', TagController::class);  

//Social
Route::post('auth/{driver}', [OAuthController::class, 'redirect']);
Route::get('auth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('auth.callback');
Route::post('sociallogin/{driver}', [OAuthController::class, 'SocialSignup']);
