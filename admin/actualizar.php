<?php
session_start(); // Asegúrate de iniciar la sesión

require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();

if (!isset($_SESSION['Id'])) {
    die("Error: No se ha iniciado sesión.");
}

$id = $_SESSION['Id'];
if (!$id) {
    die("Error: No se proporcionó el ID del usuario.");
}

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

// Procesar la actualización
if (isset($_POST['actualizar'])) {
    $idRol = $_POST['idRol'];
    $idEstadoRol = $_POST['idEstadoRol'];
    $avatar = $_POST['avatar'];
    $puntos = $_POST['puntos'];
    $nivel = $_POST['nivel'];

    $update = $con->prepare("UPDATE usuarios 
        SET ID_rol = ?, ID_estado = ?, ID_avatar = ?, puntos = ?, id_nivel = ? 
        WHERE ID_usuario = ?");
    $update->execute([$idRol, $idEstadoRol, $avatar, $puntos, $nivel, $id]);

    echo '<script>alert("Actualización exitosa")</script>';
    echo '<script>window.location = "index.php"</script>';
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
</head>
<body>
<div class="wrapper">
    <div class="form-wrapper">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Datos de Usuario</h1>
            <table border="2">
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
                            <!-- Opción actual -->
                            <option value="<?php echo $fila['ID_rol']; ?>">
                                Actualmente su rol es <?php echo $fila['rol']; ?>
                            </option>
                            <!-- Otras opciones -->
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
                            <!-- Opción actual -->
                            <option value="<?php echo $fila['ID_avatar']; ?>">
                                Actualmente su avatar es <?php echo $fila['ID_avatar']; ?>
                            </option>
                            <!-- Otras opciones -->
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
                    <td><input name="nivel" type="number" value="<?php echo $fila['id_nivel']; ?>"></td>
                    <td>
                        <select name="idEstadoRol">
                            <!-- Opción actual -->
                            <option value="<?php echo $fila['ID_estado']; ?>">
                                Actualmente su estado es <?php echo $fila['estado_rol']; ?>
                            </option>
                            <!-- Otras opciones -->
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
        </form>
    </div>
</div>
</body>
</html>
