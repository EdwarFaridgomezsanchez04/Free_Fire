<?php
session_start();
require_once('../conex/conexion.php');

if (!isset($_GET['idSala'])) {
    die("Sala no especificada.");
}

$conex = new Database();
$con = $conex->conectar();
$idSala = $_GET['idSala'];

if (!isset($_SESSION['username'])) {
    die("Usuario no autenticado.");
}

$username = $_SESSION['username'];
$sqlUser = $con->prepare("SELECT ID_usuario FROM usuarios WHERE username = :username");
$sqlUser->execute(['username' => $username]);
$user = $sqlUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuario no encontrado.");
}

$idUsuario = $user['ID_usuario'];

// Eliminar al usuario de la partida
$sqlDelete = $con->prepare("DELETE FROM partida WHERE ID_usuario = :idUsuario AND ID_sala = :idSala");
$sqlDelete->execute(['idUsuario' => $idUsuario, 'idSala' => $idSala]);

// Actualizar el número de jugadores en la sala
$sqlUpdate = $con->prepare("UPDATE salas SET jugadores_actuales = jugadores_actuales - 1 WHERE ID_sala = :idSala");
$sqlUpdate->execute(['idSala' => $idSala]);

echo "Usuario eliminado de la sala.";
?>
