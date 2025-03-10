<?php
session_start();

// Cargar el archivo JSON de armas
$armas_json = file_get_contents('armas.json');
$armas = json_decode($armas_json, true);

if (!$armas) {
    die("Error al cargar el archivo de armas");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Arma</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .contenedor-armas {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .arma {
            background-color: #222;
            padding: 15px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(255, 0, 255, 0.5);
        }
        .arma img {
            width: 100px;
            height: 100px;
        }
        .boton-seleccionar {
            background-color: purple;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .boton-seleccionar:hover {
            background-color: #9000ff;
        }
        .boton-volver {
            background-color: gray;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Selecciona tu Arma</h1>
    
    <?php foreach ($armas as $categoria => $lista): ?>
        <h2><?php echo ucfirst($categoria); ?></h2>
        <div class="contenedor-armas">
            <?php foreach ($lista as $arma): ?>
                <div class="arma">
                    <h3><?php echo htmlspecialchars($arma['nombre']); ?></h3>
                    <img src="<?php echo htmlspecialchars($arma['imagen']); ?>" alt="<?php echo htmlspecialchars($arma['nombre']); ?>">
                    <p>Balas: <?php echo $arma['balas']; ?></p>
                    <p>Daño: <?php echo $arma['dano']; ?></p>
                    <button class="boton-seleccionar">Seleccionar</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    
    <a href="index.php" class="boton-volver">Volver</a>
</body>
</html>
