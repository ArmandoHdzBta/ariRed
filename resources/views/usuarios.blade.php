@extends('layout.layout')

@section('titulo')
	<title>Usuarios</title>
@endsection

@section('css')
	{{-- expr --}}
@endsection

@section('contenido')
	<div class="container">
		<div class="row mt-5 mb-5">
			<div class="col-6 m-auto">
				<ul class="list-group list-group-flush">
					@if ($usuarios->count() > 0)
						@foreach ($usuarios as $usuario)
							<li class="list-group-item">
								<div class="row d-flex justify-content-between">
									<div class="col">
										<a href="{{ route('verPerfil', ['idusuario' => $usuario->id]) }}">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</a>
									</div>
									<div class="col">
										<button type="button" id="btnAmigo" onclick="addAmigo({{ $usuario->id }})" class="btn btn-outline-warning">
											Añadir amigo
										</button>
									</div>
								</div>
							</li>
						@endforeach
					@else
						<div class="alert alert-warning">
							aun no hay demaciados usuarios
						</div>
					@endif
				</ul>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		function addAmigo(id) {
			$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url: "{{ route('addAmigo') }}/"+id,
				type: 'POST',
				dataType: 'json',
				success: function (data){
					if(data.estatus == 'success'){
						alert(data.mensaje);
					}else{
						alert(data.mensaje);
					}
				},
			});

		}
	</script>
@endsection