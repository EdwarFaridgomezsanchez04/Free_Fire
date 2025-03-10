<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

$mapSelect = 2; // ID del mapa para Bermuda

// Obtener salas del mapa seleccionado
$sqlSalas = $con->prepare("SELECT * FROM salas WHERE ID_mapa = :id_mapa ORDER BY created_at ASC LIMIT 3");
$sqlSalas->bindParam(':id_mapa', $mapSelect, PDO::PARAM_INT);
$sqlSalas->execute();
$salas = $sqlSalas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas Disponibles - Mundo Bermuda</title>
    <link rel="stylesheet" href="styles/salas.css">
</head>
<body>
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

body {
    background-color: #000;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
}

h2 {
    color: #a855f7;
    font-size: 2rem;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.salas-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
}

.sala-card {
    background-color: #1e1e1e;
    border: 2px solid #a855f7;
    border-radius: 10px;
    padding: 20px;
    width: 200px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 0 10px rgba(168, 85, 247, 0.6);
}

.sala-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 0 20px rgba(168, 85, 247, 0.9);
}

.btn {
    display: inline-block;
    background-color: #a855f7;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #7e22ce;
}

.btn-disabled {
    background-color: #555;
    color: #bbb;
    padding: 10px 15px;
    border-radius: 5px;
    border: none;
    cursor: not-allowed;
}
</style>
    <main class="container">
        <h2>Salas disponibles - Mundo Bermuda</h2>
        <div class="salas-container">
            <?php if (isset($salas) && count($salas) > 0): ?>
                <?php foreach ($salas as $sala): ?>
                    <div class="sala-card">
                        <h3><?php echo htmlspecialchars($sala['ID_sala']); ?></h3>
                        <p>Jugadores: <?php echo htmlspecialchars($sala['jugadores_actuales']); ?>/5</p>
                        <?php if ($sala['jugadores_actuales'] < 5): ?>
                            <a href="unirse_sala.php?id_sala=<?php echo htmlspecialchars($sala['ID_sala']); ?>" class="btn">Unirse</a>
                        <?php else: ?>
                            <button class="btn-disabled">Llena</button>

                            
                            
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay salas disponibles para este mapa.</p>
            <?php endif; ?>
        </div>


</style>
    </main>
</body>
</html>