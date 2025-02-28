<?php
require '../conex/conexion.php';

$db = new Database();
$con = $db->conectar();

try {
        // Validar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileType = $_FILES['imagen']['type'];

            // Verificar el tipo de archivo y el tamaño
            $allowedTypes = ['image/jpg'];
       

            // Guardar la imagen en una carpeta
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = uniqid() . '_' . $fileName;
            $destPath = $uploadDir . $newFileName;

            $imagen = $destPath;

       

    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>