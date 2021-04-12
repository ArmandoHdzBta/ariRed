<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    public function login()
    {
    	return view('login');
    }

    public function registrarse()
    {
    	return view('registrarse');
    }

    public function home()
    {
    	$publicaciones = Publicacion::select('usuarios.id as user_id' ,'usuarios.nombre', 'usuarios.foto','publicaciones.id', 'publicaciones.texto', 'publicaciones.imagen', 'publicaciones.likes', 'publicaciones.created_at')
    					->join('usuarios' ,'usuarioId', '=', 'usuarios.id')
    					->join('amigos', 'para', '=', 'usuarios.id')
    					//->where('usuarios.id', 'publicaciones.usuarioId')
    					->where('amigos.estatus', 1)
    					//->orWhere('usuarios.id', '=', 'publicaciones.usuarioId')
    					->orderBy('created_at', 'DESC')
    					->get();

        $comentarios = Comentario::all();

    	return view('home', ['publicaciones' => $publicaciones, 'comentarios' => $comentarios]);
    }

    public function verificar(Request $datos)
    {
    	if (!$datos->email || !$datos->password)
    		return view('login', ['estatus' => 'error', 'mensaje' => '¡Los campos no pueden estar vacios!']);

    	$usuario = Usuario::where('correo', $datos->email)->first();

    	if (!$usuario)
    		return view('login', ['estatus' => 'error', 'mensaje' => '¡No existe esa cuenta!']);

    	if (!Hash::check($datos->password, $usuario->password))
    		return view('login', ['estatus' => 'error', 'mensaje' => '¡Datos incorrectos!']);

    	Session::put('usuario', $usuario);

    	if(isset($datos->url)){
            $url = decrypt($datos->url);
            return redirect($url);
        }else{
            return redirect()->route('home');
        }
    }

    public function registro(Request $datos)
    {
    	if (!$datos->nombre || !$datos->apellidoP || !$datos->apellidoM || !$datos->email || !$datos->password1 || !$datos->password2)
    		return view('registrarse', ['estatus' => 'error', 'mensaje' => '¡Los campos no pueden estar vacios!']);

    	$usuario = Usuario::where('correo', $datos->email)->first();

    	if($usuario)
    		return view('registrarse', ['estatus' => 'error', 'mensaje' => '¡El usuario ya existe!']);

    	$password1 = $datos->password1;
    	$password2 = $datos->password2;

    	if($password1 != $password2)
    		return view('registrarse', ['estatus' => 'error', 'mensaje' => '¡Las contraseñas no coinciden!']);

    	$usuario = new Usuario();
    	$usuario->nombre = $datos->nombre;
    	$usuario->apellido_paterno = $datos->apellidoP;
    	$usuario->apellido_materno = $datos->apellidoM;
    	$usuario->correo = $datos->email;
    	$usuario->password = bcrypt($datos->password1);
    	$usuario->save();

		return view('login', ['estatus' => 'success', 'mensaje' => '¡Usuario registrado exitosamente!']);

    }

    public function actualizarPerfil(Request $datos)
    {
    	if (!$datos->nombre || !$datos->apellidoP || !$datos->apellidoM || !$datos->email)
    		return view('perfil', ['estatus' => 'error', 'mensaje' => '¡Los campos no pueden estar vacios!']);

    	$usuario = Usuario::find($datos->id);
    	$usuario->nombre = $datos->nombre;
    	$usuario->apellido_paterno = $datos->apellidoP;
    	$usuario->apellido_materno = $datos->apellidoM;
    	$usuario->correo = $datos->email;

    	if ($datos->hasFile('fotoperfil')){
    		$datos->validate([
	    		'fotoperfil' => 'image',
	    	]);
	    	$usuario->foto = $datos->file('fotoperfil')->store('public');
    	}

    	$usuario->save();

    	return redirect()->route('perfil');
    }

    public function perfil()
    {
    	$publicaciones = Publicacion::select('usuarios.id as user_id' ,'usuarios.nombre', 'usuarios.foto', 'publicaciones.id', 'publicaciones.texto', 'publicaciones.imagen', 'publicaciones.likes', 'publicaciones.created_at')->join('usuarios' ,'usuarioId', '=', 'usuarios.id')->where('usuarios.id', session('usuario')->id)->orderBy('created_at', 'DESC')->get();

        $comentarios = Comentario::all();

        $fotos = Publicacion::select('imagen')->where('usuarioId', session('usuario')->id)->get();

    	return view('perfil', ['publicaciones' => $publicaciones, 'fotos' => $fotos, 'comentarios' => $comentarios]);
    }

    public function usuarios()
    {
    	$usuarios = Usuario::where('id', '!=', session('usuario')->id)->get();
    	return view('usuarios', ['usuarios' => $usuarios]);
    }

    public function salir()
    {
    	if(Session::has('usuario'))
            Session::forget('usuario');

        return redirect()->route('login');
    }
}
