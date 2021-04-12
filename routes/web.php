<?php

use App\Http\Controllers\AmigoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioPdfController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'verificar'])->name('verificar');

Route::get('/registrarse', [UsuarioController::class, 'registrarse'])->name('registrarse');
Route::post('/registrarse', [UsuarioController::class, 'registro'])->name('registro');

Route::get('/salir', [UsuarioController::class, 'salir'])->name('salir');

Route::get('/aceptarSolicitud/{idsolicitud}', [AmigoController::class, 'aceptarSolicitud'])->name('aceptarSolicitud');

Route::middleware('VerificarUsuario')->group(function (){
	Route::get('/home', [UsuarioController::class, 'home'])->name('home');
	Route::post('/home', [PublicacionController::class, 'publicacion'])->name('publicacion');

	Route::post('/like/{idpost?}', [PublicacionController::class, 'like'])->name('like');
	Route::post('/comentar/{idpost?}', [ComentarioController::class, 'comentar'])->name('comentar');

	Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
	Route::post('/perfil', [UsuarioController::class, 'actualizarPerfil'])->name('actualizarPerfil');
	Route::get('/perfil/{idusuario}', [AmigoController::class, 'verPerfil'])->name('verPerfil');
	Route::get('/descargarInfo', [UsuarioPdfController::class, 'descargarInfo'])->name('descargarInfo');

	Route::get('/usuarios', [UsuarioController::class, 'usuarios'])->name('usuarios');
	Route::post('/addAmigo/{idusuario?}', [AmigoController::class, 'addAmigoCorreo'])->name('addAmigo');
});