<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudAmigo;
use App\Models\Amigo;
use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AmigoController extends Controller
{
    public function addAmigoCorreo($idusuario)
    {
    	$amigo = Amigo::where('para', $idusuario)->first();

    	if ($amigo)
    		return json_encode(['estatus' => 'error', 'mensaje' => 'Ya has enviado la solicitud']);

    	$amigo = new Amigo();
    	$amigo->de = session('usuario')->id;
    	$amigo->para = $idusuario;
    	$amigo->estatus = 0;
    	$amigo->save();

    	$usuario = Amigo::select('usuarios.nombre as de', 'amigos.id')
    					->join('usuarios', 'de', '=', 'usuarios.id')
    					->where('amigos.de', session('usuario')->id)
    					->first();

    	$correo_para = Usuario::find($idusuario);

    	$correo = new SolicitudAmigo($usuario);

    	Mail::to($correo_para->correo)->send($correo);

    	return json_encode(['estatus' => 'success', 'mensaje' => 'Solicitud enviada']);
    }

    public function aceptarSolicitud($idsolicitud)
    {
    	$amigo = Amigo::where('id', $idsolicitud)->where('estatus', '1')->first();

    	if ($amigo){
    		echo "<h1>Ya respondiste y ahora son amigos, puedes cerrar esya ventana</h1>";
    		return false;
        }

    	$amigo = Amigo::find($idsolicitud);
    	$amigo->estatus = 1;
    	$amigo->save();

    	echo "<h1>Ya puedes cerrar esta ventana</h1>";
    }

    public function verPerfil($idUsuario)
    {
        if($idUsuario == session('usuario')->id)
            return redirect()->route('perfil');

        $usuarioPerfil = Usuario::where('id', $idUsuario)->first();

        $amigos = Amigo::where('de', session('usuario')->id)
                        ->Where('para', $idUsuario)
                        ->orWhere('para', session('usuario')->id)
                        ->first();

        if (!$amigos)
            return view('ver-perfil', ['estatus' => 'error', 'mensaje' => 'No puedes ver su informacion hasta que sean amigos']);

        if ($amigos->estatus != 1)
            return view('ver-perfil', ['estatus' => 'error', 'mensaje' => 'No puedes ver su informacion hasta que sean amigos']);

        $comentarios = Comentario::all();

        $publicaciones = Publicacion::where('usuarioId', $idUsuario)->get();

        return view('ver-perfil', ['usuarioPerfil' => $usuarioPerfil, 'publicaciones' => $publicaciones, 'comentarios' => $comentarios]);
    }
}
