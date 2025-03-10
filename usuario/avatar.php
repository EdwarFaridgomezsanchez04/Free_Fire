<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

if (!isset($_SESSION['username'])) {
    die("Acceso denegado");
}

$user_id = $_SESSION['username'];

// Obtener avatares predefinidos
$sqlAvatares = $con->prepare("SELECT imagen FROM avatar");
$sqlAvatares->execute();
$avatares = $sqlAvatares->fetchAll(PDO::FETCH_ASSOC);

// Obtener avatar actual del usuario
$sqlUsuario = $con->prepare("SELECT ID_avatar FROM usuarios WHERE ID_usuario = :id");
$sqlUsuario->bindParam(':id', $user_id, PDO::PARAM_INT);
$sqlUsuario->execute();
$usuario = $sqlUsuario->fetch(PDO::FETCH_ASSOC);

// Si la imagen existe, úsala; si no, usa una imagen por defecto
$avatarActual = !empty($usuario['ID_avatar']) ? $usuario['ID_avatar'] : 'avatars/default.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $avatar = $_FILES['imagen'];
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensionesPermitidas) && $avatar['size'] < 2000000) {
            $nombreArchivo = "avatars/" . uniqid("avatar_", true) . "." . $extension;
            if (move_uploaded_file($avatar['tmp_name'], $nombreArchivo)) {
                $stmt = $con->prepare("UPDATE usuarios SET ID_avatar = :imagen WHERE ID_usuario = :id");
                $stmt->bindParam(':imagen', $nombreArchivo, PDO::PARAM_STR);
                $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $avatarActual = $nombreArchivo; // Actualizar la imagen mostrada en la página
                echo "<p class='success'>Avatar actualizado con éxito.</p>";
            }
        } else {
            echo "<p class='error'>Formato no permitido o tamaño demasiado grande.</p>";
        }
    } elseif (isset($_POST['selected_avatar'])) {
        $selectedAvatar = $_POST['selected_avatar'];
        $stmt = $con->prepare("UPDATE usuarios SET ID_avatar = :imagen WHERE ID_usuario = :id");
        $stmt->bindParam(':imagen', $selectedAvatar, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $avatarActual = $selectedAvatar; // Actualizar la imagen mostrada en la página
        echo "<p class='success'>Avatar actualizado con éxito.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Avatar</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #9b59b6;
        }

        .avatar-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: transform 0.2s, border-color 0.3s;
        }

        .avatar:hover {
            transform: scale(1.1);
            border-color: #9b59b6;
        }

        button {
            background-color: #9b59b6;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #8e44ad;
        }

        .success {
            color: #27ae60;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
        }

        .avatar-actual {
            margin: 20px 0;
            border: 3px solid #9b59b6;
            border-radius: 50%;
            width: 120px;
            height: 120px;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Cambiar Avatar</h2>
    <p>Avatar actual:</p>
    <img src="<?php echo htmlspecialchars($avatarActual); ?>" class="avatar-actual">

    <h3>Seleccionar un avatar predefinido</h3>
    <form action="avatar.php" method="POST">
        <div class="avatar-container">
            <?php foreach ($avatares as $avatar): ?>
                <label>
                    <input type="radio" name="selected_avatar" value="<?php echo htmlspecialchars($avatar['imagen']); ?>" required>
                    <img src="<?php echo htmlspecialchars($avatar['imagen']); ?>" class="avatar">
                </label>
            <?php endforeach; ?>
        </div>
        <div class="btn-container">
            <button type="submit">Actualizar Avatar</button>
            <button type="button" onclick="window.history.back()">Volver</button>
        </div>
    </form>
</body>
</html>
