<?php
require_once('../conex/conexion.php');

if (!isset($_GET['idSala'])) {
    die("Sala no especificada.");
}

$conex = new Database();
$con = $conex->conectar();
$idSala = $_GET['idSala'];

// Obtener la capacidad de la sala
$sqlCapacidad = $con->prepare("SELECT jugadores_actuales FROM salas WHERE ID_sala = :idSala");
$sqlCapacidad->execute(['idSala' => $idSala]);
$capacidad = $sqlCapacidad->fetch(PDO::FETCH_ASSOC);

echo $capacidad ? $capacidad['jugadores_actuales'] : '0';
?>
