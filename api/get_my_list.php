<?php
session_start();
header('Content-Type: application/json');

// Sólo usuarios logueados
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

include '../config/db.php';

// Asume que tu tabla pivot se llama `mi_lista` con columnas (user_id, pelicula_id)
$stmt = $conn->prepare("SELECT pelicula_id FROM mi_lista WHERE user_id = ?");
$stmt->execute([ $_SESSION['usuario_id'] ]);
$ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($ids);
