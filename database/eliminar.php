<?php

require_once("db.php");
require_once("validar.php");

$id = isset($_POST["id"]) ? $_POST["id"] : 0;

$stmt = $conx->prepare("UPDATE usuarios SET eliminado = 1 WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: listado.php");
die();


