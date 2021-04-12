@extends('layout.layout')

@section('titulo')
	<title>Inicio</title>
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

	<div class="row">
		<div class="col-md-4 col-sm-12">
			<div class="card mt-5">
				<span class="border-top border-primary border-2"></span>
				<h3 class="card-title text-center p-3">Publica algo :D</h3>
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
				<form action="{{ route('publicacion') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row mb-3">
						<div class="input-group">
						  	<span class="input-group-text">Escribe</span>
						  	<textarea class="form-control" name="texto" aria-label="With textarea" placeholder="Que piensas?"></textarea>
						</div>
					</div>
					<div class="row mb-3">
						<div class="input-group">
						  	<input type="file" class="form-control" name="imagen" id="inputGroupFile04" aria-label="Upload">
						</div>
					</div>
					<button class="btn btn-primary">Publicar</button>
				</form>
			</div>
		</div>
		<div class="col-md-8 col-sm-12">
			<h2 class="text-center">Publicaciones de amigos</h2>
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
									<p class="text-primary text-right">{{ $publicacion->created_at }}</p>
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
											<img src="{{ Storage::url($publicacion->foto) }}" class="rounded-circle w-25 ml-2" alt="...">
										</div>
										<a href="{{ route('verPerfil', ['idusuario' => $publicacion->user_id]) }}">{{ $publicacion->nombre }}</a>
									</div>
									<div class="col-12">
										<form action="" id="formComentario">
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