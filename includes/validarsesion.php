<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex-> conectar();

if (!isset($_SESSION['Id'])) {
    // Destruir la sesión si no hay un ID de usuario en la sesión
    unset($_SESSION['Id']);
    unset($_SESSION['username']);
    unset($_SESSION['rol']);
    unset($_SESSION['type_user']);
    unset($_SESSION['code']);

    $_SESSION = array();
    session_destroy();
    session_write_close();
    echo "<script>alert('INGRESE CREDENCIALES DE LOGIN')</script>";
    echo "<script>window.location='../login.php'</script>";
    exit();
}
?>