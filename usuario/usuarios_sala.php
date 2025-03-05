<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

if (isset($_GET['id_sala'])) {
    $id_sala = $_GET['id_sala'];

    $sqlUsuarios = $con->prepare("SELECT usuarios.username FROM partidas
                                  INNER JOIN usuarios ON partidas.ID_usuario = usuarios.ID_usuario
                                  WHERE partidas.ID_sala = ?");
    $sqlUsuarios->execute([$id_sala]);
    $usuarios = $sqlUsuarios->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios en la Sala</title>
</head>
<body>
    <h3>Usuarios en la sala</h3>
    <ul>
        <?php if (isset($usuarios)) { ?>
            <?php foreach ($usuarios as $usuario) { ?>
                <li><?php echo htmlspecialchars($usuario['username']); ?></li>
            <?php } ?>
        <?php } else { ?>
            <li>No hay usuarios en esta sala.</li>
        <?php } ?>
    </ul>
</body>
</html>
