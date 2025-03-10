<?php
session_start();
require_once('../conex/conexion.php');
$conex = new Database();
$con = $conex->conectar();

class Sala {
    private $con;

    public function __construct() {
        $db = new Database();
        $this->con = $db->conectar();
    }
    public function buscarOSala($idMapa, $tipoJuego) {
        // Verificar si hay una sala disponible
        $sql = "SELECT ID_sala FROM salas WHERE ID_mapa = :idMapa AND ID_tipo_juego = :tipoJuego AND jugadores_actuales < 5 LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['idMapa' => $idMapa, 'tipoJuego' => $tipoJuego]);
        $sala = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sala) {
            // Agregar jugador a la sala existente
            $this->agregarJugadorSala($sala['ID_sala']);
            return $sala['ID_sala'];
        } else {
            // Crear una nueva sala
            return $this->crearSala($idMapa, $tipoJuego);
        }
    }

    private function agregarJugadorSala($idSala) {
        $sql = "UPDATE salas SET jugadores_actuales = jugadores_actuales + 1 WHERE ID_sala = :idSala";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['idSala' => $idSala]);
    }

    private function crearSala($idMapa, $tipoJuego) {
        // Generar un ID único para la sala
        $idSala = $this->generateUniqueId();
        $sql = "INSERT INTO salas (ID_sala, ID_mapa, ID_tipo_juego, jugadores_actuales, estado, created_at) 
        VALUES (:idSala, :idMapa, :tipoJuego, 1, 'Abierta', NOW())";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['idSala' => $idSala, 'idMapa' => $idMapa, 'tipoJuego' => $tipoJuego]);
        return $idSala;
    }

    private function generateUniqueId($length = 10) {
        return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $idMapa = $_POST['mapSelect'] ?? '';
    $tipoJuego = $_POST['gameTypeSelect'] ?? '';

    if ($idMapa && $tipoJuego) {
        $sala = new Sala();
        
        $idSala = $sala->buscarOSala($idMapa, $tipoJuego);
        
        header("Location: sala.php?idSala=$idSala");
        exit();
    }
}
?>