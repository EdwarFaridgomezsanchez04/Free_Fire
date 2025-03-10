<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();

$IdEstado = 2;
$idrol = 2;
$puntos = 0;
$vida = 100;
$nivel = 1;

// Función para generar un ID único verificando la base de datos
function generateUniqueId($con, $length = 10) {
    do {
        $id = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $stmt = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE ID_usuario = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $existe = $stmt->fetchColumn();
    } while ($existe > 0); // Genera otro ID si ya existe

    return $id;
}

if (isset($_POST['submit'])) {
    $id = generateUniqueId($con);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $avatar = $_POST['avatar'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($email) || empty($password) || empty($avatar)) {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
        echo '<script>window.location = "login.php";</script>';
        exit();
    }

    // Encriptar la contraseña
    $passw_enc = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);

    // Verificar si el usuario ya existe por email
    $sql1 = $con->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql1->bindParam(':email', $email);
    $sql1->execute();
    $fila = $sql1->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("El correo ya está registrado");</script>';
        echo '<script>window.location = "login.php";</script>';
        exit();
    }

    // Insertar el usuario en la base de datos
    $insert = $con->prepare("INSERT INTO usuarios (ID_usuario, username, email, contrasena, ID_rol, ID_avatar, ID_estado, puntos, vida, id_nivel)
        VALUES (:id, :username, :email, :passw_enc, :idrol, :avatar, :IdEstado, :puntos, :vida, :id_nivel)");
    $insert->bindParam(':id', $id);
    $insert->bindParam(':username', $username);
    $insert->bindParam(':email', $email);
    $insert->bindParam(':passw_enc', $passw_enc);
    $insert->bindParam(':idrol', $idrol);
    $insert->bindParam(':avatar', $avatar);
    $insert->bindParam(':IdEstado', $IdEstado);
    $insert->bindParam(':puntos', $puntos);
    $insert->bindParam(':vida', $vida);
    $insert->bindParam(':id_nivel', $nivel);

    if ($insert->execute()) {
        echo '<script>alert("Registro guardado exitosamente");</script>';
        echo '<script>window.location = "login.php";</script>';
    } else {
        echo '<script>alert("Error al registrar usuario");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" type="image/x-icon" href="../access/befunky_2025-2-6_11-13-32.png">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
<div class="wrapper">
    <div class="form-wrapper sign-in">
    <form method="POST" action="../includes/inicio.php" autocomplete="off">
    <h2>Iniciar sesión</h2>
        <div class="input-group">
          <input type="text" name="username" id="username" required>
          <label for="">Username</label>
        </div>
        <div class="input-group">
          <input type="password" name="password" id="password" required>
          <label for="">Password</label>
        </div>
      
        <button type="submit" name="register" id="register">Login</button>
        <div class="signUp-link">
          <p>¿No tienes una cuenta?  <a href="#" class="signUpBtn-link">Registrese</a></p>
          <p>¿Olvidaste tu <a href="recovery.php" class="signUpBtn-link">contraseña?</a></p>

        </div>
      </form>
    </div>
    <div class="form-wrapper sign-up">
      <form method="POST" action="" autocomplete="off"> 
       
      <h2>Registro</h2>

        <div class="input-group">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <label for="">Username</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="">Email</label>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>   
            <label for="">Password</label>  
            <i class='bx bx-show' id="showpass" onclick="showpass()"></i>
        </div>

        
            <div class="image-container" id="imagen">
                <img src="../usuario/avatar/chrono.png" alt="Avatar 1" class="avatar-img" data-value="1" onclick="selectAvatar(this)">
                <img src="../usuario/avatar/kelly.png" alt="Avatar 2" class="avatar-img" data-value="2" onclick="selectAvatar(this)">
                <img src="../usuario/avatar/kenta.png" alt="Avatar 3" class="avatar-img" data-value="3" onclick="selectAvatar(this)">
            </div>
            <input type="hidden" name="avatar" id="avatar" required>
        
        <button type="submit" name="submit" id="submit">Registrarse</button>
        <div class="signUp-link">
          <p>¿Ya tienes una cuenta? <a href="#" class="signInBtn-link">Iniciar sesión</a></p>
        </div>
      </form>
    </div>
</div>

<script src="../js/script.js"></script>

<script>
    function showpass() {
        const passw = document.getElementById("password");
        const iconshow = document.getElementById("showpass");
        
        if (passw.type === "password") {
            passw.type = "text";
            iconshow.classList.replace("bx-show", "bx-hide");
        } else {
            passw.type = "password";
            iconshow.classList.replace("bx-hide", "bx-show");
        }
    }

    function selectAvatar(img) {
        const avatars = document.querySelectorAll('.avatar-img');
        avatars.forEach(avatar => avatar.classList.remove('selected'));
        img.classList.add('selected');
        document.getElementById('avatar').value = img.getAttribute('data-value');
    }
</script>

<script>
        function showpass() {
            const passw = document.getElementById("password");
            const iconshow = document.getElementById("showpass");
            
            if (passw.type === "password") {
                passw.type = "text";
                iconshow.classList.replace("bx-show", "bx-hide");
            } else {
                passw.type = "password";
                iconshow.classList.replace("bx-hide", "bx-show");
            }
        }
    </script>


<script>
        function showpass() {
            const passw = document.getElementById("password");
            const iconshow = document.getElementById("showpass");
            
            if (passw.type === "password") {
                passw.type = "text";
                iconshow.classList.replace("bx-show", "bx-hide");
            } else {
                passw.type = "password";
                iconshow.classList.replace("bx-hide", "bx-show");
            }
        }
    </script>




<style>
    .image-container {
        display: flex;
        justify-content: space-around;
        margin-bottom: 5px;
    }

    .avatar-img {
        width: 100px;
        height: 100px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 50%;
    }

    .avatar-img.selected {
        border-color: blue;
    }
</style>



</body>
</html>