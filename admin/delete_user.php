<?php
session_start(); // Asegúrate de iniciar la sesión

require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();

if (!isset($_SESSION['Id'])) {
    die("Error: No se ha iniciado sesión.");
}

$code = $_SESSION['Id'];
$sql = $con->prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.ID_rol = roles.ID_rol WHERE ID_usuario = :code");
$sql->bindParam(':code', $code, PDO::PARAM_INT);
$sql->execute();
$fila = $sql->fetch(PDO::FETCH_ASSOC);

if (!$fila) {
    die("Error: No se encontró el usuario.");
}

// Aquí puedes agregar el código para eliminar el usuario si es necesario
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
</head>
<body>
    <h1>Eliminar Usuario</h1>
    <p>¿Estás seguro de que deseas eliminar al usuario <?php echo htmlspecialchars($fila['username']); ?>?</p>
    <form action="index.php" method="post">
        <input type="hidden" name="usuario_id" value="<?php echo $fila['ID_usuario']; ?>">
        <button type="submit">Eliminar</button>
    </form>
</body>
</html>
