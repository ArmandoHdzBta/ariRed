<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Informacion usuario | {{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</title>
</head>
<body>
	<table width="80%" style="margin: auto;" border="1px">
		<tr>
			<th colspan="3" style="text-align: center;"><h1>Datos personales</h1></th>
		</tr>
		<tr>
			<th><h4>Nombre</h4></th>
			<td colspan="2">{{ $usuario->nombre }}</td>
		</tr>
		<tr>
			<th><h4>Apellidos</h4></th>
			<td>{{ $usuario->apellido_paterno }}</td>
			<td>{{ $usuario->apellido_materno }}</td>
		</tr>
		<tr>
			<th>
				<h4>Correo</h4>
				<td colspan="2">{{ $usuario->correo }}</td>
			</th>
		</tr>
		<tr>
			<th colspan="3" style="text-align: center;"><h1>Actividad en la cuenta</h1></th>
		</tr>
		<tr>
			<th colspan="2"><h4>Total de publicaciones echas</h4></th>
			<td>{{ $publicaciones }}</td>
		</tr>
		<tr>
			<th colspan="2"><h4>Total de comentarios echos</h4></th>
			<td>{{ $comentarios }}</td>
		</tr>
	</table>
</body>
</html>