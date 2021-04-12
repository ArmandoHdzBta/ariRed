<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	@yield('titulo')

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/a665ad6c22.js" crossorigin="anonymous"></script>

	@yield('css')

</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg bg-info navbar-light">
		<div class="container-fluid">
			<span class="navbar-brand mb-0 ml-5 h1">Ari-Red</span>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto mb-2">
					<li class="nav-item">
						<a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('perfil') }}" class="nav-link"><i class="fas fa-user"></i> Perfil</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('usuarios') }}" class="nav-link"><i class="fas fa-users"></i> Usuarios</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('salir') }}" class="nav-link"><i class="fas fa-sign-out-alt"> Salir</i></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		@yield('contenido')
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script src="/js/jquery.min.js"></script>

	@yield('js')
</body>
</html>