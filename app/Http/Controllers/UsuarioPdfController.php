<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PDF;

class UsuarioPdfController extends Controller
{
    public function descargarInfo()
    {
    	$usuario = Usuario::where('id', session('usuario')->id)->first();

    	$comentarios = Comentario::where('usuarioId', $usuario->id)->get()->count();

    	$publicaciones = Publicacion::where('usuarioId', $usuario->id)->get()->count();

    	$pdf = PDF::loadView('datos', ['usuario' => $usuario, 'comentarios' => $comentarios, 'publicaciones' => $publicaciones]);

    	return $pdf->download($usuario->nombre.$usuario->apellido_paterno.$usuario->apellido_materno.'.pdf');
    }
}
