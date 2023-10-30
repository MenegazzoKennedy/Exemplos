<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ApiSingInController;
use App\Http\Controllers\Auth\ApiSingOutController;
use App\Http\Controllers\Auth\ApiMeController;
use App\Http\Controllers\API\ProdutoController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\LocalidadeController;
use App\Http\Controllers\API\CorretorController;
use App\Http\Controllers\API\NegociacaoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('validarapi', [ApiController::class, 'teste']);

Route::post('cadastro-usuario', [ApiController::class, 'register']);
Route::post('login', ApiSingInController::class);
Route::post('logout', ApiSingOutController::class);    
Route::middleware('auth:api')->group(function() {
    Route::post('minha-conta', ApiMeController::class);
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
    //IMOVEL
    
    Route::post('imovel/visita/{id}', [ProdutoController::class, 'agendaVisita']);
    Route::post('imovel/visita/agendadas/{id}', [ProdutoController::class, 'visitasAgendadas']);
    Route::post('imovel/visita/update/{id}', [ProdutoController::class, 'updateVisita']);
    Route::post('imovel/visita/feedback/{id}', [ProdutoController::class, 'feedbackVisita']);
    Route::post('negociacao', [NegociacaoController::class, 'negociacao']);
});

Route::apiResource('imovel', ProdutoController::class);
Route::get('imoveis/destaque', [ProdutoController::class, 'produtoDestaque']);


Route::get("/categorias/{slug}", [ProdutoController::class, 'categoria']);
Route::post("/corretores/{id}", [UserController::class, 'apresentaCorretores']);

Route::prefix('localidades')->group(function() {
    Route::get("/cidades/{id}", [LocalidadeController::class, 'consultaCidades']);
    Route::get("/estados", [LocalidadeController::class, 'consultaEstados']);
    Route::get("/{id_cidade}/locaisBairros", [LocalidadeController::class, 'consultaLocaisBairrosCidades']);
});
