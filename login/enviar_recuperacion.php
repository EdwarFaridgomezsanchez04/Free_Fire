<?php
date_default_timezone_set('America/Bogota'); // Ajusta la zona horaria según tu ubicación
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';
require '../conex/conexion.php'; // Conexión a la base de datos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);

    if (empty($email) || empty($username)) {
        echo '<script>alert("Ningún dato puede estar vacío");</script>';
        echo '<script>window.location = "recovery.php";</script>';
        exit;
    }

    // Conectar a la base de datos
    $db = new Database();
    $conn = $db->conectar();

    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT ID_usuario FROM usuarios WHERE email = ? AND username = ?");
    $stmt->execute([$email, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo '<script>alert("Email o username incorrectos");</script>';
        echo '<script>window.location = "recovery.php";</script>';
        exit;
    }

    // Generar un token único
    $token = bin2hex(random_bytes(50));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); // Expira en 1 hora

    // Guardar el token en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET reset_token = ?, reset_expira = ? WHERE ID_usuario = ?");
    $stmt->execute([$token, $expira, $user['ID_usuario']]);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juego.free.firese@gmail.com';
        $mail->Password = 'ksyi wcbu xrpk muej';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('juego.free.firese@gmail.com', 'Recuperar Contraseña');
        $mail->addAddress($email);
        $mail->Subject = 'Recuperación de contraseña - Free Fire';

        // Enlace de recuperación
        $reset_link = "http://localhost/free_fire/login/change.php?token=" . urlencode($token);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Body = "<h2>Recuperación de contraseña</h2>
                       <p>Hola, has solicitado recuperar tu contraseña.</p>
                       <p>Haz clic en el siguiente enlace para restablecerla:</p>
                       <p><a href='$reset_link' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Restablecer contraseña</a></p>
                       <p>Si no solicitaste este cambio, ignora este mensaje.</p>
                       <p>Este enlace expira en 1 hora.</p>";

        // Enviar correo
        $mail->send();
        echo '<script>alert("Revisa tu correo para restablecer la contraseña.");</script>';
        echo '<script>window.location = "change.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("Error al enviar el correo: ' . $mail->ErrorInfo . '");</script>';
    }
}
?>
