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
        echo '<script>window.location = "../login.php"</script>';
        exit();
    }

    // Se mantiene solo una consulta
    $sql = $con->prepare("SELECT * FROM usuarios WHERE username = :username");
    $sql->bindParam(':username', $username, PDO::PARAM_STR);
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        if (password_verify($passw, $fila['contraseña'])) {
            $_SESSION['Id'] = $fila['Id'];
            $_SESSION['rol'] = $fila['ID_rol'];
            $_SESSION['username'] = $fila['username'];
            $_SESSION['code'] = $fila['ID_estado'];

            if ($_SESSION['rol'] == 1) {
                header("Location: ../admin/index.php");
                exit();
            } elseif ($_SESSION['rol'] == 2) {
                header("Location: ../gestor_correspondencia/index.php");
                exit();
            } elseif ($_SESSION['rol'] == 3) {
                header("Location: ../usuario/index.php");
                exit();
            }
        } else {
            echo '<script>alert("Contraseña incorrecta")</script>';
            echo '<script>window.location = "../login.php"</script>';
            exit();
        }
    } else {
        echo '<script>alert("Usuario no encontrado")</script>';
        echo '<script>window.location = "../login.php"</script>';
        exit();
    }
}
?>
