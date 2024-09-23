<?php
	require_once("db.php");
	require_once("validar.php");

	$id = isset($_GET["id"]) ? $_GET["id"] : 0;

	$idFormulario = isset($_POST["id"]) ? $_POST["id"] : 0;
	$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
	$fecha_creacion = isset($_POST["fecha_creacion"]) ? $_POST["fecha_creacion"] : date("Y-m-d H:i:s");
	$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
	$edad = isset($_POST["edad"]) ? $_POST["edad"] : 0;
	$envio_formulario = isset($_POST["envio_formulario"]) ? $_POST["envio_formulario"] : 0;

	if ($envio_formulario == "1") {		

		$error = 0;
		$mensaje = "";

		if (empty($nombre)) {
			$error = 1;
			$mensaje = "Por favor ingrese su nombre";
		}

		if (empty($fecha_creacion)) {
			$error = 1;
			$mensaje = "Por favor ingrse su fecha";
		}

		if (empty($descripcion)) {
			$error = 1;
			$mensaje = "Por favor ingrese su descripcion";
		}

		if (empty($edad)) {
			$error = 1;
			$mensaje = "Por favor ingrese su edad";
		}

		if ($error == 0) { 			
			if ($idFormulario == 0) {				
				$sql = "INSERT INTO usuarios (nombre, fecha_creacion, descripcion, edad) ";
				$sql.= "VALUES (?, ?, ?, ?) ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("sssi", $nombre, $fecha_creacion, $descripcion, $edad);
				$stmt->execute();
				$stmt->close();
			} else {
				$sql = "UPDATE usuarios SET nombre = ?, descripcion = ?, edad = ? ";
				$sql.= "WHERE id = ? ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("ssii", $nombre, $descripcion, $edad, $idFormulario);
				$stmt->execute();
				$stmt->close();
			}
			header("Location: listado.php");
			exit();
		} else {
			echo $mensaje;
		}

	}

	$sql = "SELECT * FROM usuarios WHERE id = ? ";

	$stmt = $conx->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$resultado = $stmt->get_result();

	$usuario = $resultado->fetch_object();

	$stmt->close();

	if ($usuario === null) {
		$id = 0;
		$nombre = "";
		$fecha_creacion = date("Y-m-d H:i:s");
		$descripcion = "";
		$edad = 0;
	} else {
		$id = $usuario->ID;
		$nombre = $usuario->nombre;
		$fecha_creacion = $usuario->fecha_creacion;
		$descripcion = $usuario->descripcion;
		$edad = $usuario->edad;
	}
?>

<form method="POST">
	<input type="hidden" value="1" name="envio_formulario">

	<input type="hidden" name="id" value="<?php echo $id ?>">

	<label>Ingrese su nombre</label><br>
	<input type="text" value="<?php echo $nombre ?>" name="nombre"/>

	<?php if ($id == 0) { ?>
		<br><label>Fecha de creacion</label><br>
		<input type="datetime-local" value="<?php echo $fecha_creacion ?>" name="fecha_creacion">
	<?php } else { ?>
		<input type="hidden" value="<?php echo $fecha_creacion ?>" name="fecha_creacion">
	<?php } ?>

	<br><label>Descripcion</label><br>
	<textarea name="descripcion" rows="5"><?php echo $descripcion ?></textarea>

	<br><label>Edad</label><br>
	<input type="number" value="<?php echo $edad ?>" name="edad">

	<input type="submit">
</form>