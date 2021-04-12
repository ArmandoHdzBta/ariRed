@extends('layout.layout-forms')

@section('titulo')
	<title>Iniciar sesion</title>
@endsection

@section('contenido')
	<div class="card w-50 m-auto mt-5">
		<h3 class="card-title text-center">Inicia sesion</h3>
		@if (isset($estatus))
			@if ($estatus == 'success')
				<div class="alert alert-success">
					{{ $mensaje }}
				</div>
			@else
				<div class="alert alert-warning">
					{{ $mensaje }}
				</div>
			@endif
		@endif
		<form action="{{ route('verificar') }}" method="POST">
			@csrf
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
				  	<input type="email" class="form-control" name="email" placeholder="Correo" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
				  	<input type="password" class="form-control" name="password" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			 @if(isset($_GET["oops"]))
		      	<input type="hidden" name="url" value="{{$_GET["oops"]}}">
		    @endif
			<button type="submit" class="btn btn-success">Iniciar sesion</button>
		</form>
		<a href="{{ route('registrarse') }}" class="btn-link">Registrarse</a>
	</div>
@endsection