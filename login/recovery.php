<?php
session_start();
require_once('../conex/conexion.php');
$conexion = new Database();
$conex = $conexion->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $correo = trim($_POST['email']);
    $documento = trim($_POST['username']);

    if (empty($correo) || empty($documento)) {
        echo '<script>alert("Ningún dato puede estar vacío");</script>';
    } else {
        // Verificar si el usuario existe
        $sql = $conex->prepare("SELECT email, username FROM usuarios WHERE email = :email AND username = :username");
        $sql->bindParam(':email', $correo, PDO::PARAM_STR);
        $sql->bindParam(':username', $documento, PDO::PARAM_STR);
        $sql->execute();

        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $_SESSION['email'] = $fila['email'];
            $_SESSION['username'] = $fila['username'];

            // Redirigir con datos de recuperación
            echo '<form id="sendForm" action="enviar_recuperacion.php" method="POST">
                      <input type="hidden" name="email" value="' . htmlspecialchars($correo, ENT_QUOTES, 'UTF-8') . '">
                      <input type="hidden" name="username" value="' . htmlspecialchars($documento, ENT_QUOTES, 'UTF-8') . '">
                  </form>
                  <script>document.getElementById("sendForm").submit();</script>';
            exit;
        } else {
            echo '<script>alert("Correo o username incorrectos");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="icon" type="image/x-icon" href="../access/befunky_2025-2-6_11-13-32.png">
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
        <div class="form-wrapper recovery">
            <form action="" method="POST" autocomplete="off">
                <h2>¿Olvidaste tu contraseña?</h2>
                <p>No te preocupes, restableceremos tu contraseña. Solo dinos con qué dirección de email te registraste en Free Fire.</p>
                <div class="input-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="buttons">
                    <a href="login.php"><button type="button" class="secondary-btn">Regresar</button></a>
                    <button type="submit" class="primary-btn" name="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
