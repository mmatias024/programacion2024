<?php
	require_once("db.php");
	@session_start();

	$email = isset($_POST["email"]) ? ($_POST["email"]) : "";
	$password = isset($_POST["password"]) ? ($_POST["password"]) : "";

	if (!empty($email) && !empty($password)){


		$stmt = $conx->prepare("SELECT * FROM administradores WHERE email = ? AND password = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		
		$dato = $stmt->get_result();
		$stmt->close();

		$usuario = $dato->fetch_object();

		if ($usuario === NULL) {
			echo "usuario o contraseña incorrecta<br>";

		} else {
			$_SESSION["id"] = $usuario->id;
			header("Location: listado.php");
			die();
		}
	}



?>
<form method="POST">
	<input type="email" name="email" placeholder="ingrese su email" required>
	<input type="password" name="password" placeholder="ingrese su contraseña" required>
	<input type="submit">
</form>

