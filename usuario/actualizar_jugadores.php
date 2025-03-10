<?php
require_once('../conex/conexion.php');

if (!isset($_GET['idSala'])) {
    die("Sala no especificada.");
}

$conex = new Database();
$con = $conex->conectar();
$idSala = $_GET['idSala'];

$sqlJugadores = $con->prepare(" SELECT usuarios.username 
    FROM partida 
    INNER JOIN usuarios ON partida.ID_usuario = usuarios.ID_usuario 
    WHERE partida.ID_sala = :idSala
");
$sqlJugadores->execute(['idSala' => $idSala]);
$jugadores = $sqlJugadores->fetchAll(PDO::FETCH_ASSOC);

foreach ($jugadores as $jugador) {
    echo "<li>" . htmlspecialchars($jugador['username']) . "</li>";
}
?>
