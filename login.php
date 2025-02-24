<?php
require_once('conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
$IdEstado = 1;
$idrol = 1;
function generateUniqueId($length = 10) {
    $id = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $id;
}
?>

<?php
if (isset($_POST['submit'])) {
    $id = generateUniqueId();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // echo $document, $name, $last,$id_sexo, $age, $user, $password, $id_type_user;

    $passw_enc = password_hash($password, PASSWORD_DEFAULT, array("cost" => 12));


    $sql1 = $con->prepare("SELECT * FROM usuario WHERE Id = $id");
    $sql1->execute();
    $fila = $sql1->fetchAll(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Ya existe el documento");</script>';
        echo '<script>window.location = "registro.php";</script>';
    }


    if ( $username == "" || $email == "" || $id == "" || $password == "") {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
        echo '<script>window.location = "registro.php";</script>';
    } else {

        $insert = $con->prepare("INSERT INTO usuario (Id, Username, Contrasena, Email, Estado, rol)
         VALUES ('$id', '$username', '$passw_enc', '$email', '$IdEstado', '$idrol')");
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
          <input type="text" name="username" id="username"required>
          <label for="">Username</label>
        </div>
        <div class="input-group">
          <input type="password" name="password" id="password"required>
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
    </div>

    <div class="form-wrapper sign-up">
      <form method="POST"   action="" autocomplete="off">
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
            <input type="password" name= "password" id="password" placeholder="Password" required>   
            <label for="">Password</label>  
            <i class='bx bx-show' id="showpass" onclick="showpass()"></i>
        </div>

        <div class="remember">
          <label><input type="checkbox"> I agree to the terms & conditions</label>
 
        </div>
        <button type="submit" name="submit" id="submit" >Sign Up</button>
        <div class="signUp-link">
          <p>Already have an account? <a href="#" class="signInBtn-link">Sign In</a></p>
        </div>
    </div>

      </form>
    
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
    </script>
</body>
</html>