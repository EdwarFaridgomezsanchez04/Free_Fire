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
$expira = $_GET['token'];



// Verificar si el token existe en la base de datos y obtener el usuario
$query = $conex->prepare("SELECT ID_usuario, username, email FROM usuarios WHERE reset_token = ? AND reset_expira > NOW()");
$query->execute([$token] );
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <style>
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons a,
        .buttons button {
            flex: 1;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper change-password">
            <form action="" method="POST" autocomplete="off">
                <h2>Cambiar Contraseña</h2>
                <p>Por favor, ingresa tu nueva contraseña.</p>
                <div class="input-group">
                    <input type="password" id="password1" name="password1" required>
                    <label for="password1">Nueva Contraseña</label>
                    <i class='bx bx-show' id="showpass1" onclick="showpass1()"></i>
                </div>
                <div class="input-group">
                    <input type="password" id="password2" name="password2" required>
                    <label for="password2">Confirmar Contraseña</label>
                    <i class='bx bx-show' id="showpass2" onclick="showpass2()"></i>
                </div>
                <div class="buttons">
                    <a href="login.php"><button type="button" class="secondary-btn">Cancelar</button></a>
                    <button type="submit" class="primary-btn" name="submit">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showpass1() {
            const passw = document.getElementById("password1");
            const iconshow = document.getElementById("showpass1");
            
            if (passw.type === "password") {
                passw.type = "text";
                iconshow.classList.replace("bx-show", "bx-hide");
            } else {
                passw.type = "password";
                iconshow.classList.replace("bx-hide", "bx-show");
            }
        }

        function showpass2() {
            const passw = document.getElementById("password2");
            const iconshow = document.getElementById("showpass2");
            
            if (passw.type === "password") {
                passw.type = "text";
                iconshow.classList.replace("bx-show", "bx-hide");
            } else {
                passw.type = "password";
                iconshow.classList.replace("bx-hide", "bx-show");
            }
        }
    </script>
</body>
</html>



