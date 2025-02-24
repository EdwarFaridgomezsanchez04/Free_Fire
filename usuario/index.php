<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="profile-info">
            
            <h2><?php
             $insert = $con->prepare("SELECT * FROM usuario WHERE Username = '$username'");
              $insert->execute();  
             ?></h2>
            <p>Nivel: 10</p>
            <p>Puntos: 1500</p>
        </div>
        <div class="avatar">
            <img src="Multimedia/avatar.png" alt="Avatar del Jugador">
        </div>
        <div class="world-selection">
            <select id="worldSelect" class="form-select">
                <option value="BR">BR-Clasificatoria</option>
                <option value="DE">DE-Clasificatoria</option>
            </select>
            <button class="btn btn-primary" onclick="iniciarJuego()">Iniciar Juego</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const worldSelect = new Choices('#worldSelect', {
                position: 'top', // Esto hará que el menú se despliegue hacia arriba
            });
        });

        function iniciarJuego() {
            const mundo = document.getElementById('worldSelect').value;
            alert('Iniciando juego en el mundo: ' + mundo);
        }
    </script>
</body>
</html>