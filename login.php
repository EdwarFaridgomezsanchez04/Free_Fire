<?php
require_once('conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();

$IdEstado = 1;
$idrol = 2;
$puntos = 0;
$vida = 100;
$nivel = 1;

function generateUniqueId($length = 10) {
    return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

if (isset($_POST['submit'])) {
    $id = generateUniqueId();
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $avatar = isset($_POST['avatar']) ? $_POST['avatar'] : null;

    if (empty($username) || empty($email) || empty($password) || empty($avatar)) {
        echo '<script>alert("Todos los campos son obligatorios"); window.location = "registro.php";</script>';
        exit();
    }

    $passw_enc = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);

    $sql1 = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $sql1->bindParam(':email', $email);
    $sql1->execute();
    
    if ($sql1->fetchColumn() > 0) {
        echo '<script>alert("El correo ya está registrado"); window.location = "registro.php";</script>';
        exit();
    }

    $insert = $con->prepare("INSERT INTO usuarios 
        (ID_usuario, username, email, contrasena, ID_rol, ID_avatar, ID_estado, puntos, vida, id_nivel) 
        VALUES (:id, :username, :email, :passw_enc, :idrol, :avatar, :IdEstado, :puntos, :vida, :id_nivel)");

    $insert->bindParam(':id', $id);
    $insert->bindParam(':username', $username);
    $insert->bindParam(':email', $email);
    $insert->bindParam(':passw_enc', $passw_enc);
    $insert->bindParam(':idrol', $idrol);
    $insert->bindParam(':avatar', $avatar);
    $insert->bindParam(':IdEstado', $IdEstado);
    $insert->bindParam(':puntos', $puntos);
    $insert->bindParam(':vida', $vida);
    $insert->bindParam(':id_nivel', $nivel);
    
    if ($insert->execute()) {
        echo '<script>alert("Registro exitoso"); window.location = "login.php";</script>';
    } else {
        echo '<script>alert("Error en el registro"); window.location = "registro.php";</script>';
    }
    exit();
}
?>
