<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ImovelController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth','auth.admin'])->name('dashboard.')->group(function() {
    Route::get('/teste', [HomeController::class, 'teste'])->name('teste');
    Route::resource('usuarios', UserController::class)->except(['show', 'create', 'store']);
    Route::get('usuarios/status/{id}/{status}', [UserController::class, 'status'])->name('status');
    Route::get('/construtora', [HomeController::class, 'construtora'])->name('construtora');
    
    Route::resource('produtos', ImovelController::class)->except(['show', 'create', 'store']);
    Route::prefix('/imovel')->group(function() {
        Route::post('/cadastrar', [ImovelController::class, 'cadastraImovel'])->name('cadastrar-imovel');
        Route::get('/cadastrar-view', [ImovelController::class, 'cadastraImovelView'])->name('cadastrar-view');
        Route::get('/status/{id}', [ImovelController::class, 'imovelStatus'])->name('produtoStatus');
    });
    Route::resource('/categoria', CategoriaController::class)->except(['show', 'create', 'store']);
    Route::get('/categoria/new', [CategoriaController::class, 'categoriaNew'])->name("categoria-new");
    Route::post('/categoria/insercao', [CategoriaController::class, 'categoriaInsercao'])->name("categoria-insercao");
    Route::get('/categoria/status/{id}', [CategoriaController::class, 'status'])->name('categoriaStatus');
    Route::resource('/documento', DocumentoController::class)->except(['show', 'create', 'store']);
    Route::get('/documento/status/{id}', [DocumentoController::class, 'status'])->name('documentoStatus');

    Route::resource('/visita', VisitaController::class)->except(['show', 'create', 'store']);
    Route::get('/visita/status/{id}', [VisitaController::class, 'status'])->name('visitaStatus');
    Route::post('/cadastrar-view/estado', [ImovelController::class, 'imovelEstado'])->name('imovel-estado');
    Route::post('/cadastrar-view/cidade', [ImovelController::class, 'imovelCidade'])->name('imovel-cidade');
});

//AUTH SOCIAL
Route::get('/facebook/redirect', [SocialAuthController::class, 'redirect'])->name('login.facebook');
Route::get('/facebook/callback', [SocialAuthController::class, 'callback']);
//Route::get('/google/redirect', [SocialAuthController::class, 'redirect_google'])->name('login.google');
//Route::get('/google/callback', [SocialAuthController::class, 'callback_google']);

//cache
Route::get('/clear', [ConfigController::class, 'clearRoute']);