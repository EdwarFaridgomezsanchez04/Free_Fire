<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

$username = $_SESSION['username'];

// Obtener las estadísticas del jugador
$sql = $con->prepare("SELECT usuarios.username, usuarios.puntos, nivel.nivel,     
                      INNER JOIN nivel ON usuarios.id_nivel = nivel.id_nivel 
                      WHERE usuarios.username = :username");
$sql->execute(['username' => $username]);
$jugador = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Perfil del Jugador</h1>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?php echo htmlspecialchars($jugador['username']); ?></h3>
                <p class="card-text"><strong>Nivel:</strong> <?php echo htmlspecialchars($jugador['nivel']); ?></p>
                <p class="card-text"><strong>Puntos:</strong> <?php echo htmlspecialchars($jugador['puntos']); ?></p>
                <p class="card-text"><strong>Partidas Ganadas:</strong> <?php echo htmlspecialchars($jugador['partidas_ganadas']); ?></p>
                <p class="card-text"><strong>Partidas Perdidas:</strong> <?php echo htmlspecialchars($jugador['partidas_perdidas']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>