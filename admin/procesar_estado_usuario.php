<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "base_free";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error ());
}

$usuario_id = $_POST['usuario_id'];
$nuevo_estado = (isset($_POST['estado']) && $_POST['estado'] == 'on') ? 'Activo' : 'Inactivo';

$sql = "UPDATE usuarios SET ID_estado=(SELECT ID_estado FROM estado WHERE estado='$nuevo_estado') WHERE ID_usuario='$usuario_id'";
if (mysqli_query($conexion, $sql)) {
    echo "Estado actualizado correctamente.";
} else {
    echo "Error al actualizar el estado: " . mysqli_error($conexion);
}

// Redirige o realiza otras acciones según sea necesario
header("Location: index.php");
exit();
?>
