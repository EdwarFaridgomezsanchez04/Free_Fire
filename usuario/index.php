<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();

$username = $_SESSION['username'];

$sql = $con->prepare("SELECT usuarios.*, nivel.*, avatar.imagen AS avatar_imagen FROM usuarios 
                      INNER JOIN nivel ON usuarios.id_nivel = nivel.id_nivel 
                      INNER JOIN avatar ON usuarios.ID_avatar = avatar.ID_avatar 
                      WHERE username = :username");
$sql->execute(['username' => $username]); // ✅ PASAMOS EL PARÁMETRO
$fila = $sql->fetch(PDO::FETCH_ASSOC);


$secondWorldSelectValue = $_POST['secondWorldSelect'] ?? ''; 
$worldSelectDisabled = ($secondWorldSelectValue !== 'world2');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">

        <div class="profile-info">
            
            <h2><?php
             $insert = $con->prepare("SELECT * FROM usuario WHERE Username = '$username'");
              $insert->execute();  
             ?></h2>
            <p>Nivel: 10</p>
            <p>Puntos: 1500</p>
        </div>
        <div class="avatar">
            <img src="Multimedia/avatar.png" alt="Avatar del Jugador">
        </div>
        <div class="world-selection">
            <select id="worldSelect" class="form-select">
                <option value="BR">BR-Clasificatoria</option>
                <option value="DE">DE-Clasificatoria</option>
            </select>
            <button class="btn btn-primary" onclick="iniciarJuego()">Iniciar Juego</button>
        </div>

       <a href="perfil.php"> <div class="profile-info">
          
                <h2><?php echo ($fila['username']); ?></h2>
                <p>ID: <?php echo ($fila['ID_usuario']); ?></p>
                <p>Nivel: <?php echo ($fila['id_nivel']); ?></p>
                <p>Puntos: <?php echo ($fila['puntos']); ?></p>
        </div></a>
        <div class="avatar">
        <img src="<?php echo htmlspecialchars($fila['avatar_imagen']); ?>" alt="Avatar del Jugador" width="400" height="400">
         

        </div>
        <form method="post" action="">
            <div class="world-selection">
                <select id="worldSelect" name=ss"worldSelect" class="form-select" <?php echo $worldSelectDisabled ? 'disabled' : ''; ?>>
                    <option value="BR">BR-Clasificatoria</option>
                    <option value="DE">DE-Clasificatoria</option>
                </select>
                <select id="secondWorldSelect" name="secondWorldSelect" class="form-select" onchange="this.form.submit()">
                    <option value="">Selecciona un mundo</option>
                    <option value="world1" <?php echo $secondWorldSelectValue === 'world1' ? 'selected' : '1'; ?>>Mundo 1</option>
                    <option value="world2" <?php echo $secondWorldSelectValue === 'world2' ? 'selected' : '2'; ?>>Mundo 2</option>
                </select>
                <button class="btn btn-primary" type="submit">Iniciar Juego</button>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const worldSelect = new Choices('#worldSelect', {
                position: 'top', // Esto hará que el menú se despliegue hacia arriba
            });



            const secondWorldSelect = new Choices('#secondWorldSelect', {
                position: 'top', // Esto hará que el menú se despliegue hacia arriba
            });

        });

        function iniciarJuego() {
            const mundo = document.getElementById('worldSelect').value;
            alert('Iniciando juego en el mundo: ' + mundo);
        }
    </script>
</body>
</html>