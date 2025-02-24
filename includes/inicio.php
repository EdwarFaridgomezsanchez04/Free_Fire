<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();


if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $passw = $_POST['password'];

    // echo $email, $passw; 


    if ($username == '' || $passw == '') {
        echo '<script>alert("Ningún dato puede estar vacío")</script>';
        echo '<script>window.location = "../login.php"</script>';
    }

    $sql = $con->prepare("SELECT * FROM usuario WHERE Username = '$username'");  
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
    
        if (password_verify($passw, $fila['Contrasena']) && ($fila['rol'] == 1)) {

            $_SESSION['Id'] = $fila['Id'];
            $_SESSION['rol'] = $fila['rol'];
            $_SESSION['type_user'] = 1;

            echo $_SESSION['Id'], $_SESSION['rol'];


            if ($_SESSION ['type_user'] == 1) {
                header("Location: ../usuario/index.php");
                exit();
            }

            if ($_SESSION ['type_user'] == 2) {
                header("Location: ../gestor_correspondencia/index.php");
                exit();
            }

            if ($_SESSION ['type_user'] == 3) {
                header("Location: ../usuario/index.php");
                exit();
            }


         
            
        } 
        }

        
    
}
?>