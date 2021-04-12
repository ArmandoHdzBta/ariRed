<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function publicacion(Request $datos)
    {
    	$publicacion = new Publicacion();

    	$datos->validate([
    		'imagen' => 'image',
    	]);

    	if ($datos->hasFile('imagen')){

	    	$publicacion->imagen = $datos->file('imagen')->store('public');
    	}


    	if ($datos->texto) {
    		$publicacion->texto = $datos->texto;
    	}

    	$publicacion->usuarioId = session('usuario')->id;
    	$publicacion->save();

    	return redirect()->route('home');

    }

    public function like($idpost)
    {
    	$publicacion = Publicacion::find($idpost);

    	$publicacion->likes = $publicacion->likes + 1;

    	$verificar = $publicacion->save();

    	if($verificar)
    		return json_encode(['estatus' => 'success' ,'mensaje' => 'Ya le diste like a la publicacion']);
    	else
    		return json_encode(['estatus' => 'error' ,'mensaje' => 'Hubo un error']);
    }

}
