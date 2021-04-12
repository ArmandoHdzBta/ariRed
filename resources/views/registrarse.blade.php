@extends('layout.layout-forms')

@section('titulo')
	<title>Registrarse</title>
@endsection

@section('contenido')
	<div class="card w-50 m-auto mt-5">
		<h3 class="card-title text-center">Registrate</h3>
		@if (isset($estatus))
			@if ($estatus == 'error')
				<div class="alert alert-warning">
					{{ $mensaje }}
				</div>
			@else
				<div class="alert alert-danger">
					{{ $mensaje }}
				</div>
			@endif
		@endif
		<form action="{{ route('registro') }}" method="POST">
			@csrf
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
				  	<input type="text" class="form-control" name="nombre" placeholder="Nombre" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
				  	<input type="text" class="form-control" name="apellidoP" placeholder="Apellido Paterno" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
				  	<input type="text" class="form-control" name="apellidoM" placeholder="Apellido Materno" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
				  	<input type="email" class="form-control" name="email" placeholder="Correo" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
				  	<input type="password" class="form-control" name="password1" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="row">
				<div class="input-group mb-3">
				 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
				  	<input type="password" class="form-control" name="password2" placeholder="Repite la contraseña" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</div>
			<button type="submit" class="btn btn-success w-100">Registrarse</button>
		</form>
		<a href="{{ route('login') }}" class="btn-link">Iniciar sesion</a>
	</div>
@endsection