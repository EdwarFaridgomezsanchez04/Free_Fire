<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

if (!isset($_SESSION['username']) || !isset($_GET['id_sala'])) {
    die("Acceso denegado.");
}

$username = $_SESSION['username'];
$idSala = intval($_GET['id_sala']); // Asegurar que sea un número

// Obtener el ID del usuario basado en el username
$sqlUser = $con->prepare("SELECT ID_usuario FROM usuarios WHERE username = :username");
$sqlUser->execute([':username' => $username]);
$user = $sqlUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuario no encontrado.");
}

$idUsuario = $user['ID_usuario'];

// Verificar si la sala aún tiene espacio
$sql = $con->prepare("SELECT jugadores_actuales FROM salas WHERE ID_sala = :id_sala");
$sql->execute([':id_sala' => $idSala]);
$sala = $sql->fetch(PDO::FETCH_ASSOC);

if (!$sala) {
    die("La sala no existe.");
}

if ($sala['jugadores_actuales'] >= 5) {
    die("La sala está llena.");
}

// Agregar jugador a la sala
$sql = $con->prepare("INSERT INTO partida (ID_usuario, ID_sala) VALUES (:idUsuario, :idSala)");
$sql->execute([':idUsuario' => $idUsuario, ':idSala' => $idSala]);

// Actualizar cantidad de jugadores en la sala
$sql = $con->prepare("UPDATE salas SET jugadores_actuales = jugadores_actuales + 1 WHERE ID_sala = :id_sala");
$sql->execute([':id_sala' => $idSala]);

// Redirigir a la sala
header("Location: sala.php?idSala=$idSala");
exit();
?>