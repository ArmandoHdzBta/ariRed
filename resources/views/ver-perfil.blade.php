@extends('layout.layout')

@section('titulo')
	<title>Usuario bloqueado hasta que sean amigos</title>
@endsection

@section('css')
	{{-- expr --}}
@endsection

@section('contenido')
	<div class="container-fluid">
		@if (isset($estatus))
			<div class="card w-25 m-auto mt-5">
				<div class="card-header">
					<h1>Usuario bloqueado</h1>
				</div>
				<div class="card-body">
					<div class="alert alert-warning">
						{{ $mensaje }}
					</div>
				</div>
			</div>
		@else
		<div class="card mt-5 w-75 m-auto">
			<div class="card-header">
				<h4>{{ $usuarioPerfil->nombre }}</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="row">
						<div class="col-6">
							<img src="{{ Storage::url($usuarioPerfil->foto) }}" class="img-thumbnail w-25 m-auto" alt="foto perfil">
						</div>
					</div>
					<div class="row">
						<div class="row">
							<h5>Nombre</h5>
						</div>
						<div class="row">
							<span>{{ $usuarioPerfil->nombre }}</span>
						</div>
						<div class="row">
							<h5>Apellidos</h5>
						</div>
						<div class="row">
							<div class="col">
								<span>{{ $usuarioPerfil->apellido_paterno }}</span>
							</div>
							<div class="col">
								<span>{{ $usuarioPerfil->apellido_materno }}</span>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<hr>
				<div class="row">
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
													<img src="{{ Storage::url($usuarioPerfil->foto) }}" class="rounded-circle w-25 ml-2" alt="...">
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
										  		<div class="card-body">
										  			<div class="row">
														<div class="col-12">
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
			<div class="card-footer">
				<div class="alert alert-secondary">
					<p>
						Miembro desde {{ $usuarioPerfil->created_at }}
					</p>
				</div>
			</div>
		</div>
		@endif
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
	</script>
@endsection