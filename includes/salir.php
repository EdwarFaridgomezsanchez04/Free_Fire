<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
unset($_SESSION['Id']);
unset($_SESSION['rol']);


unset($_SESSION['username']);

unset($_SESSION['estado']);
unset($_SESSION['correo']);
session_destroy();
session_write_close();

header("Location: ../login.php");
?>
