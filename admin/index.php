<?php



require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start(); // Asegúrate de iniciar la sesión


if (!isset($_SESSION['Id'])) {
    die("Error: No se ha iniciado sesión.");
}
?>
<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "base_free";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    
    <link rel="stylesheet" href="switch.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
   <div> <br>
   <h1 class="text-center tit">LISTA DE USUARIOS</h1>
<div class="container table-responsive">
    <div>
        
    </div>
    <!--------TABLAS------------>
    <style>
    .table {
        font-size: 14px; /* Tamaño de la fuente de la tabla */
        border-radius: 20px;
    }
    .table-rounded {
        border-collapse: collapse;
        border-spacing: 0 -2px;
    }
    .table-rounded th,
    .table-rounded td {
        border: 1px solid #dee2e6; /* Define el color del borde */
        border-radius: 10px; /* Ajusta el valor para lograr el redondeo deseado */
    }
    th, td {
        padding: 8px; /* Relleno de las celdas */
        text-align: center; /* Alineación del texto en las celdas */
    }
</style>
    <table class="table table-light table-bordered border-secondary table-rounded">
        <thead class="table-dark">
            <tr>
        <th scope="col" style="width: 30px; vertical-align: middle;">ID USUARIO</th>
        <th scope="col" style="width: 300px; vertical-align: middle;">USERNAME</th>
        <th scope="col" style="width: 100px; vertical-align: middle;">EMAIL</th>
        <th scope="col" style="width: 150px; vertical-align: middle;">ROL</th>
        <th scope="col" style="width: 150px; vertical-align: middle;">AVATAR</th>
        <th scope="col" style="width: 150px; vertical-align: middle;">PUNTOS</th>
        <th scope="col" style="width: 150px; vertical-align: middle;">NIVEL</th>
        <th scope="col" style="width: 150px; vertical-align: middle;">ESTADO</th>


        <th scope="col" style="width: 80px; vertical-align: middle;">Editar</th>
        <th scope="col" style="width: 80px; vertical-align: middle;">Eliminar</th>
            </tr>
        </thead>
        <tbody>

            <?php

            $sql = "SELECT usuarios.ID_usuario, usuarios.username, usuarios.email, usuarios.ID_rol, usuarios.ID_avatar, 
                             usuarios.puntos, usuarios.id_nivel, roles.rol, estado.estado, avatar.imagen
                           FROM usuarios
                           LEFT JOIN estado ON usuarios.ID_estado = estado.ID_estado
                           LEFT JOIN avatar ON usuarios.ID_avatar = avatar.ID_avatar
                           LEFT JOIN roles ON usuarios.ID_rol = roles.ID_rol";
            $result = mysqli_query($conexion, $sql);
            
            $numeroCorrelativo = 1;

            while ($mostrar = mysqli_fetch_array($result)) {
            ?>

                <tr>
                    <td><?php echo $mostrar['ID_usuario'] ?></td>
                    <td><?php echo $mostrar['username'] ?></td>
                    <td><?php echo $mostrar['email'] ?></td>
                    <td><?php echo $mostrar['rol'] ?></td>
                    <td><img src="../usuario/<?php echo htmlspecialchars($mostrar['imagen']); ?>" alt="Avatar" width="50" height="50"></td>
                    <td><?php echo $mostrar['puntos'] ?></td>
                    <td><?php echo $mostrar['id_nivel'] ?></td>
                    <td>
                        <form id="estadoForm<?php echo $mostrar['ID_usuario']; ?>" action="procesar_estado_usuario.php" method="post">
                            <input type="hidden" name="usuario_id" value="<?php echo $mostrar['ID_usuario']; ?>">
                            <input class="switch" type="checkbox" id="estadoCheckbox<?php echo $mostrar['ID_usuario']; ?>" name="estado" <?php echo ($mostrar['estado'] == 'Activo') ? 'checked' : ''; ?>>
                        </form>
                    </td>
                    <script>
                        // Asigna la función al evento clic del checkbox
                        document.getElementById('estadoCheckbox<?php echo $mostrar['ID_usuario']; ?>').addEventListener('click', function() {
                            document.getElementById('estadoForm<?php echo $mostrar['ID_usuario']; ?>').submit();
                            this.disabled = true; // Desactiva el checkbox después de hacer clic
                        });
                    </script>
                  
                    <td>
                    <a href="actualizar.php" onclick="window.open('actualizar.php?id=<?php echo $resu['ID_usuario']; ?>', '', 'width=600, height=500, toolbar=NO')">
                    <input class="btn btn-success btn-sm" type="button"  value="Editar"> </a>
                    </td>
                    <td>
                        <a href="delete_user.php">
                        <input class="btn btn-danger btn-sm" type="button" value="Eliminar"></a>
                    </td>
                </tr>
            <?php
                // Incrementa la variable para el próximo número correlativo
                $numeroCorrelativo++;
            }
            ?>
        </tbody>
    </table>

<div class="text-center">
    <a class="btn btn-danger" href="../includes/salir.php">Cerrar Sesion</a>
</div><br>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>