<?php
session_start(); // Asegurar sesión iniciada

require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

if (!isset($_SESSION['Id'])) {
    die("Error: No se ha iniciado sesión.");
}

if (!isset($_GET['ID_usuario']) || empty($_GET['ID_usuario'])) {
    die("Error: No se ha proporcionado un ID de usuario válido.");
}

$id = $_GET['ID_usuario'];

// Obtener datos del usuario
$sql = $con->prepare("SELECT usuarios.*, roles.rol, estado.estado AS estado_rol FROM usuarios
    INNER JOIN roles ON usuarios.ID_rol = roles.ID_rol
    INNER JOIN estado ON usuarios.ID_estado = estado.ID_estado
    WHERE ID_usuario = :id");
$sql->bindParam(':id', $id, PDO::PARAM_INT);
$sql->execute();
$fila = $sql->fetch(PDO::FETCH_ASSOC);

if (!$fila) {
    die("Error: No se encontró un usuario con el ID proporcionado.");
}

// Procesar actualización
if (isset($_POST['actualizar'])) {
    $idRol = $_POST['idRol'];
    $idEstadoRol = $_POST['idEstadoRol'];
    $avatar = $_POST['avatar'];
    $puntos = $_POST['puntos'];
    $nivel = $_POST['nivel'];

    if (!empty($nivel)) {
        $update = $con->prepare("UPDATE usuarios SET ID_rol = ?, ID_estado = ?, ID_avatar = ?, puntos = ?, id_nivel = ? WHERE ID_usuario = ?");
        $update->execute([$idRol, $idEstadoRol, $avatar, $puntos, $nivel, $id]);

        echo '<script>alert("Actualización exitosa"); window.location = "index.php";</script>';
        exit;
    } else {
        echo '<script>alert("Error: Debes seleccionar un nivel válido.");</script>';
    }
}

// Procesar eliminación
if (isset($_POST['Eliminar'])) {
    $delete = $con->prepare("DELETE FROM usuarios WHERE ID_usuario = ?");
    $delete->execute([$id]);
    echo '<script>alert("Usuario eliminado exitosamente"); window.location = "index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Actualización de Usuarios</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .wrapper {
            width: 90%;
            max-width: 800px;
            background: #121212;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        h1 {
            color: #a855f7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #444;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 8px;
            background: #222;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }

        .primary-btn, .secondary-btn, .back-btn {
            background: #a855f7;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .primary-btn:hover, .secondary-btn:hover {
            background: #9333ea;
        }

        .secondary-btn {
            background: #6b21a8;
        }

        .secondary-btn:hover {
            background: #4c1d95;
        }

        .back-btn {
            background: #444;
        }

        .back-btn:hover {
            background: #666;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1>Datos de Usuario</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td>ID Usuario</td>
                <td>Username</td>
                <td>Email</td>
                <td>Rol</td>
                <td>Avatar</td>
                <td>Puntos</td>
                <td>Nivel</td>
                <td>Estado</td>
            </tr>
            <tr>
                <td><input name="Documento" type="number" readonly value="<?php echo $fila['ID_usuario']; ?>"></td>
                <td><input name="Nombre" type="text" readonly value="<?php echo $fila['username']; ?>"></td>
                <td><input name="Correo" type="text" readonly value="<?php echo $fila['email']; ?>"></td>
                <td>
                    <select name="idRol">
                        <option value="<?php echo $fila['ID_rol']; ?>">Actualmente: <?php echo $fila['rol']; ?></option>
                        <?php
                        $sql = $con->prepare("SELECT * FROM roles");
                        $sql->execute();
                        while ($fila1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila1['ID_rol'] . "'>" . $fila1['rol'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="avatar">
                        <option value="<?php echo $fila['ID_avatar']; ?>">Actualmente: <?php echo $fila['ID_avatar']; ?></option>
                        <?php
                        $sql = $con->prepare("SELECT * FROM avatar");
                        $sql->execute();
                        while ($fila3 = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila3['ID_avatar'] . "'>" . $fila3['ID_avatar'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input name="puntos" type="number" value="<?php echo $fila['puntos']; ?>"></td>
                <td>
                    <select name="nivel">
                        <option value="<?php echo $fila['id_nivel']; ?>">Actualmente: <?php echo $fila['id_nivel']; ?></option>
                        <?php
                        $sql = $con->prepare("SELECT * FROM nivel");
                        $sql->execute();
                        while ($fila4 = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila4['id_nivel'] . "'>" . $fila4['id_nivel'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="idEstadoRol">
                        <option value="<?php echo $fila['ID_estado']; ?>">Actualmente: <?php echo $fila['estado_rol']; ?></option>
                        <?php
                        $sql = $con->prepare("SELECT * FROM estado");
                        $sql->execute();
                        while ($fila2 = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila2['ID_estado'] . "'>" . $fila2['estado'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <br><br>
<input type="submit" value="Actualizar" name="actualizar" class="primary-btn">
<input type="submit" value="Eliminar" name="Eliminar" class="secondary-btn">
<button type="button" class="secondary-btn" onclick="window.history.back();">Volver</button>

    </form>
<style>body {
    background-color: #000;
    color: #fff;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.wrapper {
    width: 90%;
    max-width: 800px;
    background: #121212;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
}

.form-wrapper {
    text-align: center;
}

h1 {
    color: #a855f7;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #444;
}

td {
    padding: 10px;
    text-align: center;
}

input, select {
    width: 100%;
    padding: 8px;
    background: #222;
    color: #fff;
    border: 1px solid #555;
    border-radius: 5px;
}

.primary-btn, .secondary-btn {
    background: #a855f7;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.primary-btn:hover, .secondary-btn:hover {
    background: #9333ea;
}

.secondary-btn {
    background: #6b21a8;
}

.secondary-btn:hover {
    background: #4c1d95;
}
</style>
</div>
</body>
</html>
