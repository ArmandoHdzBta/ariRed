<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function comentar($idpost, Request $datos)
    {
        if(!$datos->comentario || !$datos->idusuario)
            return json_encode(['estatus' => 'error', 'mensaje' => 'Si quieres comentar no puede estar vacio el comentario']);

        $comentario = new Comentario();
        $comentario->texto = $datos->comentario;
        $comentario->usuarioId = $datos->idusuario;
        $comentario->publicacionId = $idpost;
        $comentario->save();

        return json_encode(['estatus' => 'success', 'mensaje' => 'Has comentado la publicacion']);
    }
}
