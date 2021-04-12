@extends('layout.layout')

@section('titulo')
	<title>Perfil | {{ session('usuario')->nombre }} {{ session('usuario')->apellido_paterno }}</title>
@endsection

@section('css')
	<style>
		.btn-action{
			width: 100%;
			background-color: purple;
		}
	</style>
@endsection

@section('contenido')
	<div class="container-md-10 m-auto">
		<div class="row mt-5 mb-5">
			<div class="col-md-6 col-sm-12">
				<h3 class="text-center">Perfil</h3>
				<div class="col-3">
					<img src="{{ Storage::url(session('usuario')->foto) }}" class="img-thumbnail m-auto" alt="...">
				</div>
				<div class="col-4">
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
					<form action="{{ route('actualizarPerfil') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<input type="hidden" name="id" value="{{ session('usuario')->id }}">
							<div class="input-group mb-3">
							 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  	<input type="text" class="form-control" name="nombre" value="{{ session('usuario')->nombre }}" placeholder="Nombre" aria-label="Username" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="row">
							<div class="input-group mb-3">
							 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  	<input type="text" class="form-control" name="apellidoP" value="{{ session('usuario')->apellido_paterno }}" placeholder="Apellido Paterno" aria-label="Username" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="row">
							<div class="input-group mb-3">
							 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
							  	<input type="text" class="form-control" name="apellidoM" value="{{ session('usuario')->apellido_materno }}" placeholder="Apellido Materno" aria-label="Username" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="row">
							<div class="input-group mb-3">
							 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
							  	<input type="email" class="form-control" name="email" value="{{ session('usuario')->correo }}" placeholder="Correo" aria-label="Username" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="row">
							<div class="input-group mb-3">
							 	<span class="input-group-text" id="basic-addon1"><i class="fas fa-image"></i></span>
							  	<input type="file" class="form-control" name="fotoperfil" aria-label="Username" aria-describedby="basic-addon1">
							</div>
							@error('fotoperfil')
								<small class="text-danger">Debe de ser una foto</small>
							@enderror
						</div>
						<button type="submit" class="btn btn-success w-100">Actualizar</button>
					</form>
					<a href="{{ route('descargarInfo') }}" target="_blank" class="btn btn-info">Descargar informacion</a>
				</div>
				<div class="card">
					<div class="row">
						<div class="col-12 d-flex justify-content-between">
							<div class="col-2"><h4>Fotos</h4></div>
							<div class="col-2">
								<button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#fotos" aria-expanded="false" aria-controls="fotos">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="col-12 collapse" id="fotos">
							<div class="d-flex col-12">
								<div class="row">
									@if ($fotos->count() > 0)
										@foreach ($fotos as $foto)
											@if ($foto->imagen != null)
												<div class="col-md-3">
													<img src="{{ Storage::url($foto->imagen) }}" class="rounded w-75 ml-2" alt="...">
												</div>
											@endif
										@endforeach
									@else
										<div class="alert alert-warning">
											Aun no hay fotos para mostrar
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<h2 class="text-center">Publicaciones</h2>
				<div class="col-md-12 col-sm-12">
					@if ($publicaciones->count() > 0)
						@foreach ($publicaciones as $publicacion)
							<div class="card mt-5 mb-2 w-75 m-auto">
								<span class="border border-top border-warning border-2"></span>
								<div class="row">
									<div class="row">
										<div class="col-md-6 ml-2">
											<img src="{{ Storage::url($publicacion->foto) }}" class="rounded-circle w-25 ml-2" alt="...">
											<a href="{{ route('verPerfil', ['idusuario' => $publicacion->user_id]) }}">{{ $publicacion->nombre }}</a>
										</div>
										<div class="col-md-6">
											<p class="text-primary text-right">
												{{ $publicacion->created_at }}
											</p>
										</div>
									</div>
									<div class="row">
										@if ($publicacion->texto != null)
											<div class="row">
												<p>{{ $publicacion->texto }}</p>
											</div>
										@endif
										@if ($publicacion->imagen != null)
											<div class="row mb-2">
												<img src="{{ Storage::url($publicacion->imagen) }}" alt="Imagen si hay">
											</div>
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<button type="button" onclick="like({{ $publicacion->id }})" class="btn btn-action w-100 text-center"><i class="fas fa-heart"></i> {{ $publicacion->likes }}</button>
									</div>
									<div class="col-6">
										<button class="btn btn-action" type="button" data-bs-toggle="collapse" data-bs-target="#comentarios" aria-expanded="false" aria-controls="comentarios">
				    						<i class="fas fa-comment"></i>
				  						</button>
									</div>
								</div>
								<div class="collapse" id="comentarios">
								  	<div class="card">
								  		<div class="card-header">
								  			<div class="col-md-12 ml-2">
												<div class="col-4">
													<img src="{{ Storage::url('default.png') }}" class="rounded-circle w-25 ml-2" alt="...">
												</div>
												<a href="">Usuario</a>
											</div>
											<div class="col-12">
												<form action="" method="POST" id="formComentario">
													@csrf
													<input type="hidden" name="idusuario" value="{{ session('usuario')->id }}">
													<div class="input-group">
													  	<span class="input-group-text">Escribe</span>
													  	<textarea class="form-control" name="comentario" aria-label="With textarea" placeholder="Que piensas?"></textarea>
													</div>
													<button type="button" onclick="comentar({{ $publicacion->id }})" class="btn btn-primary">Comentar</button>
												</form>
											</div>
								  		</div>
								  		<div class="card-body">
								  			<div class="row">
								  				@foreach ($comentarios as $comentario)
								  					@if ($comentario->publicacionId == $publicacion->id)
								  						<div class="col-12">
															<p>
																{{ $comentario->texto }}
															</p>
														</div>
								  					@endif
								  				@endforeach
								  			</div>
								  		</div>
								  	</div>
								</div>
							</div>
						@endforeach
					@else
						<div class="alert alert-warning">
							Aun no hay publicaciones
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		function like(id) {
			$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url: "{{ route('like') }}/"+id,
				type: 'POST',
				dataType: 'json',
				success: function (data){
					if (data.estatus == 'success'){
						alert(data.mensaje);
						location.reload();
					}else{
						alert(data.mensaje);
					}
				},
			});
		}

		function comentar(idpublicacion) {
			$.ajax({
				url: "{{ route('comentar') }}/"+idpublicacion,
				type: 'POST',
				dataType: 'json',
				data: $('#formComentario').serialize(),
				success: function(data){
					if (data.estatus == 'success'){
						alert(data.mensaje);
						location.reload();
					}else{
						alert(data.mensaje);
					}
				},
			});
		}
	</script>
@endsection