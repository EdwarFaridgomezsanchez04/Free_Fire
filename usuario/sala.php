<?php
session_start();
require_once('../conex/conexion.php');

// Conectar a la base de datos
$conex = new Database();
$con = $conex->conectar();

// Verificar si se recibe el ID de la sala
if (!isset($_GET['idSala'])) {
    die("Sala no especificada.");
}

$idSala = $_GET['idSala'];

// Obtener el ID del usuario
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

// Obtener detalles de la sala
$sql = $con->prepare("SELECT * FROM salas WHERE ID_sala = :idSala");
$sql->execute(['idSala' => $idSala]);
$sala = $sql->fetch(PDO::FETCH_ASSOC);

if (!$sala) {
    die("La sala no existe.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sala <?php echo htmlspecialchars($sala['ID_sala']); ?></title>
    <link rel="stylesheet" href="salastyles.css">
    <script>
        // Función para actualizar la lista de jugadores
        function actualizarJugadores() {
            fetch('actualizar_jugadores.php?idSala=<?php echo $idSala; ?>')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('lista-jugadores').innerHTML = data;
                });
        }

        // Función para actualizar la capacidad de la sala
        function actualizarCapacidad() {
            fetch('actualizar_capacidad.php?idSala=<?php echo $idSala; ?>')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('capacidad-sala').innerText = data;
                });
        }

        // Actualiza cada 5 segundos
        setInterval(actualizarJugadores, 5000);
        setInterval(actualizarCapacidad, 5000);

        // Salir de la sala con AJAX
        function salirSala() {
            fetch('salir_sala.php?idSala=<?php echo $idSala; ?>')
                .then(() => {
                    window.location.href = 'index.php';
                });
        }
    </script>
</head>
<body>
    <h2>Sala #<?php echo htmlspecialchars($sala['ID_sala']); ?></h2>
    <p>Mapa: <?php echo htmlspecialchars($sala['ID_mapa']); ?></p>
    <p>Modo de juego: <?php echo htmlspecialchars($sala['ID_tipo_juego']); ?></p> 
    <p>Capacidad: <span id="capacidad-sala"><?php echo $sala['jugadores_actuales']; ?></span> / <?php echo $sala['jugadores_maximos']; ?></p>

    <h3>Jugadores en la sala:</h3>
    <ul id="lista-jugadores">
        <!-- La lista de jugadores se actualizará con AJAX -->
        <?php include 'actualizar_jugadores.php'; ?>
    </ul>

    <button onclick="salirSala()">Volver al menú</button>
</body>
</html>
