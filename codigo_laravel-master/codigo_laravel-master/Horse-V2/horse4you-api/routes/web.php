<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagCrmController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\PublicacoesController;
use App\Http\Controllers\AnuncioController;

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
    //Route::get('/teste', [HomeController::class, 'index'])->name('home');
    Route::resource('usuarios', UserController::class)->except(['show', 'create', 'store']);
    Route::get('/tags/{status}', [TagCrmController::class, 'showStatus']);
    Route::get('/tags/status/{id}/{newstatus}', [TagCrmController::class, 'status'])->name('tagStatus');
    Route::resource('tags', TagCrmController::class)->except(['show']);
    Route::resource('denuncia', DenunciaController::class);
    Route::get('tipo/denuncia', [DenunciaController::class, 'indexTipo'])->name('tipoDenuncia');
    Route::get('tipo/denuncia/edit/{id}', [DenunciaController::class, 'editTipo'])->name('editTipo');
    Route::put('tipo/denuncia/update/{id}', [DenunciaController::class, 'updateTipo'])->name('updateTipo');
    Route::post('reenvio/senha/usuario/{user_id}', [UserController::class, 'reenvioSenhaUser'])->name('reenvioSenhaUserRota');
    Route::resource('publicacoes', PublicacoesController::class);
    Route::resource('anuncios', AnuncioController::class);
});

//cache
Route::get('/clear', [ConfigController::class, 'clearRoute']);