<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

function generateUniqueId($length = 9) {
    $id_sala = str_pad(random_int(0, pow(9, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $id_sala;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; // Obtenido desde la sesión
    $id_sala = generateUniqueId();

    
    $sqlInsert1 = $con->prepare("INSERT INTO salas (ID_sala) VALUES ($id_sala)");



    // Verificar si el usuario ya está en la sala
    $sqlCheck = $con->prepare("SELECT * FROM partidas 
                               INNER JOIN usuarios ON partidas.ID_usuario = usuarios.ID_usuario 
                               WHERE usuarios.username = ? AND partidas.ID_sala = ?");
    $sqlCheck->execute([$username, $id_sala]);

    if ($sqlCheck->rowCount() == 0) {
        // Obtener el ID del usuario basado en el username
        $sqlUser = $con->prepare("SELECT ID_usuario FROM usuarios WHERE username = ?");
        $sqlUser->execute([$username]);
        $user = $sqlUser->fetch(PDO::FETCH_ASSOC);
        $id_usuario = $user['ID_usuario'];


        // Insertar usuario en la sala
         $sqlInsert = $con->prepare("INSERT INTO partida (ID_jugador, ID_usuario, ID_sala, puntos_partida) VALUES (?, ?, ?, 0)");
        $sqlInsert->execute([$id_usuario, $id_usuario, $id_sala]);
            echo "Usuario agregado a la sala exitosamente.";
      
    } else {
        echo "El usuario ya está en esta sala.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unirse a una Sala</title>
</head>
<body>
    <form method="POST" action="">
        ?>
    </select>
    <button type="submit">Unirse</button>
</form>
