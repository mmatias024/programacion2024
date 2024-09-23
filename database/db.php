<?php
$servidor = "localhost"; // o 127.0.0.1
$user = "root";
$password = "";
$database = "Base_de_mati";

$conx = new mysqli($servidor, $user, $password, $database);

if ($conx->connect_error) {
	echo "error: ".$conx->connect_error;
}