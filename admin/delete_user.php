<?php
session_start(); // Iniciar sesión

require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

if (!isset($_SESSION['Id'])) {
    die("Error: No se ha iniciado sesión.");
}

// Verificar si se proporciona un ID de usuario para eliminar
if (!isset($_GET['id'])) {
    die("Error: No se proporcionó un usuario válido.");
}

$usuario_id = $_GET['id']; // ID del usuario a eliminar

// Obtener los datos del usuario
$sql = $con->prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.ID_rol = roles.ID_rol WHERE ID_usuario = :usuario_id");
$sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$sql->execute();
$fila = $sql->fetch(PDO::FETCH_ASSOC);

if (!$fila) {
    die("Error: No se encontró el usuario.");
}

// Bloquear eliminación del usuario administrador (puedes cambiar esto si tienes un ID específico para admins)
if ($usuario_id == $_SESSION['Id']) {
    die("Error: No puedes eliminar tu propia cuenta.");
}

// Código para eliminar el usuario cuando se confirme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete = $con->prepare("DELETE FROM usuarios WHERE ID_usuario = :usuario_id");
    $delete->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    
    if ($delete->execute()) {
        echo "<script>alert('Usuario eliminado correctamente.'); window.location.href='index.php';</script>";
    } else {
        echo "Error al eliminar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Eliminar Usuario</h1>
        <p>¿Estás seguro de que deseas eliminar a <b><?php echo htmlspecialchars($fila['username']); ?></b>?</p>
        
        <form method="POST">
            <button type="submit">Eliminar</button>
            <a href="index.php"><button type="button">Cancelar</button></a>
        </form>
    </div>
</body>
</html>
