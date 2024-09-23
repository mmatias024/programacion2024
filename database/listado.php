<?php

require_once("db.php");
require_once("validar.php");


$stmt = $conx->prepare("SELECT * FROM usuarios WHERE eliminado = 0");
$stmt->execute();

$resultadoSTMT = $stmt->get_result();

$nuestroResultado = [];

while ($fila = $resultadoSTMT->fetch_object()) {
	$nuestroResultado[] = $fila;
}

$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<a href="formulario.php">Nuevo Usuario</a>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Fecha de creacion</th>
				<th>Descripcion</th>
				<th>Edad</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($nuestroResultado as $fila) { ?>
				<tr>
					<td><?php echo $fila->ID ?></td>
					<td><?php echo $fila->nombre ?></td>
					<td><?php echo $fila->fecha_creacion ?></td>
					<td><?php echo $fila->descripcion ?></td>
					<td><?php echo $fila->edad ?></td>
					<td>
						<a href="formulario.php?id=<?php echo $fila->ID ?>">Editar</a>
						<form action="eliminar.php" method="POST">
							<input type="hidden" value="<?php echo $fila->ID ?>" name="id">
							<input type="submit" value="Eliminar">
						</form>
					</td>


				</tr>
			<?php } ?>
		</tbody>
	</table>

</body>
</html>