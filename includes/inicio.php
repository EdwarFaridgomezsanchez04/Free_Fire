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

    $sql = $con->prepare("SELECT * FROM usuarios WHERE username = '$username'");  
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
    
        if (password_verify($passw, $fila['contrasena']) && ($fila['ID_rol'] == 1 || $fila['ID_rol'] == 2)) {

            $_SESSION['Id'] = $fila['Id'];
            $_SESSION['rol'] = $fila['rol'];
            $_SESSION ['username'] = $fila['username'];
            $_SESSION ['type_user'] = $fila['ID_rol'];
            $_SESSION ['code'] = $fila['ID_estado'];


            echo $_SESSION['Id'], $_SESSION['rol'];

            if ($_SESSION ['type_user'] == 1) {
                header("Location: ../admin/index.php");
                exit();
            }

            if ($_SESSION ['type_user'] == 2) {
                header("Location: ../usuario/index.php");
                exit();
            }


          


         
            
        } 
        }

        
    
}
?>