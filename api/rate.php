<?php
session_start();
header('Content-Type: application/json');
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit();
}
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$pelicula_id = intval($input['pelicula_id'] ?? 0);
$score       = intval($input['score']       ?? 0);
$user_id     = $_SESSION['usuario_id'];

if ($pelicula_id < 1 || $score < 1 || $score > 10) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit();
}

try {
    // ¿Ya tenía valoración?
    $stmt = $conn->prepare("SELECT id FROM valoracion WHERE user_id = ? AND pelicula_id = ?");
    $stmt->execute([$user_id, $pelicula_id]);
    if ($stmt->fetch()) {
        $upd = $conn->prepare("UPDATE valoracion 
                               SET puntuacion = ? 
                               WHERE user_id = ? AND pelicula_id = ?");
        $upd->execute([$score, $user_id, $pelicula_id]);
    } else {
        $ins = $conn->prepare("INSERT INTO valoracion (user_id, pelicula_id, puntuacion)
                               VALUES (?, ?, ?)");
        $ins->execute([$user_id, $pelicula_id, $score]);
    }
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}