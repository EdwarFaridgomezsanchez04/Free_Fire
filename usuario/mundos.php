<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Mundo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .world-container {
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .world-container:hover {
            transform: scale(1.05);
        }
        .world-container img {
            width: 100%;
            max-width: 320px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(138, 43, 226, 0.6);
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .world-container img:hover {
            box-shadow: 0px 8px 20px rgba(138, 43, 226, 0.9);
            transform: translateY(-5px);
        }
        .btn-custom {
            background-color: #6a0dad;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
            display: block;
            margin: 10px auto;
            width: 80%;
            max-width: 200px;
        }
        .btn-custom:hover {
            background-color: #8a2be2;
            transform: scale(1.05);
        }
        .btn-back {
            display: block;
            margin: 20px auto;
            background-color: #4b0082;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
            text-decoration: none;
            width: 80%;
            max-width: 150px;
        }
        .btn-back:hover {
            background-color: #6a0dad;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Selecciona un Mundo</h1>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="world-container">
                    <a href="salas_bermuda.php">
                        <img src="../access/bermuda.png" alt="Mundo Bermuda">
                    </a>
                    <a href="salas_bermuda.php" class="btn btn-custom">Mundo Bermuda</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="world-container">
                    <a href="salas_purgatorio.php">
                        <img src="../access/purgatorio.png" alt="Mundo Purgatorio">
                    </a>
                    <a href="salas_purgatorio.php" class="btn btn-custom">Mundo Purgatorio</a>
                </div>
            </div>
        </div>
        <a href="index.php" class="btn-back">Volver</a>
    </div>
</body>
</html>
