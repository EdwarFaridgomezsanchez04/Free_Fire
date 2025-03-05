<?php
session_start();
include '../conex/conexion.php';
$conex = new database();
$con = $conex->conectar();


$nombreJugador = $_POST['username'] ?? '';

if (!$nombreJugador) {
    echo "Error: Nombre vacío";
    exit;
}

// Buscar una sala abierta con menos de 5 jugadores
$sql = "SELECT ID_sala FROM salas WHERE jugadores_actuales < 5 AND estado = 'abierta' LIMIT 1";
$result = $conn->query($sql);

if ($result-> $num_rows > 0) {
    $row = $result->fetch();
    $salaId = $row['ID_sala'];

    $conn->query("INSERT INTO usuarios (username, ID_sala) VALUES ('$nombreJugador', $salaId)");
    $conn->query("UPDATE salas SET jugadores_actuales = jugadores_actuales + 1 WHERE id = $salaId");

    if ($conn->query("SELECT jugadores_actuales FROM salas WHERE ID_salas = $salaId")->fetch()['jugadores_actuales'] == 5) {
        $conn->query("UPDATE salas SET estado = 'Llena' WHERE ID_sala = $salaId");
    }
} else {
    $codigoSala = substr(md5(uniqid()), 0, 6);
    $conn->query("INSERT INTO salas (codigo, jugadores_actuales) VALUES ('$codigoSala', 1)");
    $salaId = $conn-> $insert_id;
    
    $conn->query("INSERT INTO usuarios (username, ID_sala) VALUES ('$nombreJugador', $salaId)");
}


echo "Jugador $nombreJugador asignado a la sala $salaId.";
?>
