<?php
require_once('conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
$IdEstado = 1;
$idrol = 2;
$puntos = 0;
$vida = 100;
$nivel = 1;


function generateUniqueId($length = 10) {
    $id = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $id;
}

if (isset($_POST['submit'])) {
    $id = generateUniqueId();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = $_POST['avatar']; // Obtener el avatar seleccionado

    $passw_enc = password_hash($password, PASSWORD_DEFAULT, array("cost" => 12));

    $sql1 = $con->prepare("SELECT * FROM usuarios WHERE ID_usuario = :id");
    $sql1->bindParam(':id', $id);
    $sql1->execute();
    $fila = $sql1->fetchAll(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Ya existe el documento");</script>';
        echo '<script>window.location = "registro.php";</script>';
    }

    if ($username == "" || $email == "" || $id == "" || $password == "" || $avatar == "") {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
        echo '<script>window.location = "registro.php";</script>';
    } else {
        $insert = $con->prepare("INSERT INTO usuarios (ID_usuario, username, email, contrasena, ID_rol, ID_avatar, ID_estado, puntos, vida, id_nivel)
         VALUES (:id, :username, :email, :passw_enc, :idrol, :avatar, :IdEstado, :puntos, :vida , :id_nivel)");
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

        $insert->execute();    

        echo '<script>alert("Registro guardado exitosamente");</script>';
        echo '<script>window.location = "login.php";</script>';
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
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="wrapper">
    <div class="form-wrapper sign-in">
    <form method="POST" action="includes/inicio.php" autocomplete="off">
    <h2>Login</h2>
        <div class="input-group">
          <input type="text" name="username" id="username" required>
          <label for="">Username</label>
        </div>
        <div class="input-group">
          <input type="password" name="password" id="password" required>
          <label for="">Password</label>
        </div>
        <div class="remember">
          <label><input type="checkbox"> Remember me</label>
        </div>
        <button type="submit" name="register" id="register">Login</button>
        <div class="signUp-link">
          <p>Don't have an account? <a href="#" class="signUpBtn-link">Sign Up</a></p>
        </div>
      </form>
    </div><br>

    <div class="form-wrapper sign-up">
      <form method="POST" action="" autocomplete="off">
        <h2>Sign Up</h2>

        <div class="input-group">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <label for="">Username</label>
        </div>

        <div class="input-group">
            <input type="text" name="email" id="email" placeholder="Email" required>
            <label for="">Email</label>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>   
            <label for="">Password</label>  
            <i class='bx bx-show' id="showpass" onclick="showpass()"></i>
        </div>

        <div class="input-group">
        
            <div class="image-container" id="imagen">
                <img src="usuario/avatar/one.gif" alt="Avatar 1" class="avatar-img" data-value="1" onclick="selectAvatar(this)">
                <img src="usuario/avatar/two.gif" alt="Avatar 2" class="avatar-img" data-value="2" onclick="selectAvatar(this)">
                <img src="usuario/avatar/three.gif" alt="Avatar 3" class="avatar-img" data-value="3" onclick="selectAvatar(this)">
            </div>
            <input type="hidden" name="avatar" id="avatar" required>
        </div>SS
        <button type="submit" name="submit" id="submit">Sign Up</button>
        <div class="signUp-link">
          <p>Already have an account? <a href="#" class="signInBtn-link">Sign In</a></p>
        </div>
      </form>
    </div>
</div>

<script src="script.js"></script>

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
<style>
    .image-container {
        display: flex;
        justify-content: space-around;
        margin-bottom: 10px;
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