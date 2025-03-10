<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

$username = $_SESSION['username'];

// Obtener las estadísticas del jugador
$sql = $con->prepare("SELECT usuarios.*, nivel.*, avatar.imagen AS avatar_imagen FROM usuarios 
                      INNER JOIN nivel ON usuarios.id_nivel = nivel.id_nivel 
                      INNER JOIN avatar ON usuarios.ID_avatar = avatar.ID_avatar 
                      WHERE usuarios.username = :username");
$sql->execute(['username' => $username]);
$fila = $sql->fetch(PDO::FETCH_ASSOC);

// Obtener todos los mapas disponibles
$sqlMapas = $con->prepare("SELECT * FROM mapas");
$sqlMapas->execute();
$mapas = $sqlMapas->fetchAll(PDO::FETCH_ASSOC);

$mapSelectValue = $_POST['mapSelect'] ?? '';
$gameTypeSelectValue = $_POST['gameTypeSelect'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Jugador</title>
    <link rel="icon" type="image/x-icon" href="../access/befunky_2025-2-6_11-13-32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <a href="perfil.php">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($fila['username']); ?></h2>
                <p>ID: <?php echo htmlspecialchars($fila['ID_usuario']); ?></p>
                <p>Nivel: <?php echo htmlspecialchars($fila['id_nivel']); ?></p>
                <p>Puntos: <?php echo htmlspecialchars($fila['puntos']); ?></p>
            </div>
        </a>

        <div class="profile-info1">
            <a href="avatar.php">Avatares</a>
        </div>

        <div class="profile-info2">
            <a href="armas.php">Armas</a>
        </div>

        <div class="avatar">
            <img src="<?php echo htmlspecialchars($fila['avatar_imagen']); ?>" alt="Avatar del Jugador" width="400" height="400">
        </div>

        <form method="post" action="mundos.php">
            <div class="world-selection">
            
                
                <button class="btn btn-primary" type="submit">Seleccionar Mundo</button>
            </div>
        </form>
        </div>


</body>
</html>