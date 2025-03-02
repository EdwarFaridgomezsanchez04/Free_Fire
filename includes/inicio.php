<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $passw = $_POST['password'];

    if ($username == '' || $passw == '') {
        echo '<script>alert("Ningún dato puede estar vacío")</script>';
        echo '<script>window.location = "../login/login.php"</script>';
        exit();
    }

    $sql = $con->prepare("SELECT * FROM usuarios WHERE username = :username");
    $sql->bindParam(':username', $username, PDO::PARAM_STR);
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        if (password_verify($passw, $fila['contrasena']) && ($fila['ID_rol'] == 1 || $fila['ID_rol'] == 2) && $fila['ID_estado'] == 1) {
            $_SESSION['Id'] = $fila['ID_usuario'];
            $_SESSION['username'] = $fila['username'];
            $_SESSION['type_user'] = $fila['ID_rol'];
            $_SESSION['estado'] = $fila['ID_estado'];

            echo $_SESSION['Id'], $_SESSION['type_user'], $_SESSION['estado'];

            if ($_SESSION['type_user'] == 1) {
                header("Location: ../admin/index.php");
                exit();
            }

            if ($_SESSION['type_user'] == 2) {
                header("Location: ../usuario/index.php");
                exit();
            }
        } else {
            echo '<script>alert("Contraseña incorrecta o usuario no autorizado")</script>';
            echo '<script>window.location = "../login/login.php"</script>';
            exit();
        }
    } else {
        echo '<script>alert("Usuario no encontrado")</script>';
        echo '<script>window.location = "../login/login.php"</script>';
        exit();
    }
}
?>