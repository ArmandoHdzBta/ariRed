<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>¿Amigo?</title>
	<style>
		.container-fluid{
			width: 100%;
		}
		.container{
			width: 80%;
			margin: auto;
		}
		.card{
			border: 1px solid lightgreen;
			border-radius: 8px;
			width: 80%;
			margin: auto;
		}
		h1{
			text-align: center;
			font-family: 'Verdana';
			color: #000;
		}
		p{
			margin-top: 2%;
			margin-bottom: 2%;
			font-family: 'Verdana';
			color: #000;
		}
		a{
			display: block;
			padding: 5px;
			text-decoration: none;
			font-size: 20px;
			background: lightgreen;
			border-radius: 5px;
			color: #000;
		}
	</style>
</head>
<body class="">
	<div class="container-fluid">
		<div class="container">
			<div class="card">
				<h1>¡Hola!</h1>
				<p>El usuario {{ $datos->de }} quiere añadirte como amigo</p>
				<p>da click en el boton para aceptar</p>
				<a href="{{ route('aceptarSolicitud', ['idsolicitud' => $datos->id]) }}">Aceptar</a>
			</div>
		</div>
	</div>
</body>
</html>