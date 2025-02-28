<?php
session_start();
require_once('../conex/conexion.php');
$conexion = new database();
$conex = $conexion->conectar();

if (!isset($_GET['token'])) {
    echo '<script>alert("Acceso no autorizado.");</script>';
    echo '<script>window.location = "recovery.php";</script>';
    exit;
}

$token = $_GET['token'];

// Verificar si el token existe en la base de datos y obtener el usuario
$query = $conex->prepare("SELECT ID_usuario, username, email FROM usuarios WHERE reset_token = ? AND reset_expira > NOW()");
$query->execute([$token]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo '<script>alert("El token es inválido o ha expirado.");</script>';
    echo '<script>window.location = "recovery.php";</script>';
    exit;
}

$id_usuario = $user['ID_usuario'];
$username = $user['username'];
$email = $user['email'];

if (isset($_POST['submit'])) {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if (strlen($password1) < 6) {
        echo '<script>alert("La contraseña debe tener al menos 6 caracteres.");</script>';
    } elseif ($password1 !== $password2) {
        echo '<script>alert("Las contraseñas no coinciden.");</script>';
    } else {
        $hashedPassword = password_hash($password2, PASSWORD_DEFAULT, array("cost" => 12));

        // Actualizar la contraseña y limpiar el token de recuperación
        $update = $conex->prepare("UPDATE usuarios SET contrasena = ?, reset_token = NULL, reset_expira = NULL WHERE ID_usuario = ?");
        $update->execute([$hashedPassword, $id_usuario]);

        if ($update) {
            echo '<script>alert("Contraseña actualizada exitosamente.");</script>';
            echo '<script>window.location = "login.php";</script>';
        } else {
            echo '<script>alert("Error al actualizar la contraseña.");</script>';
        }
    }
}
?>
