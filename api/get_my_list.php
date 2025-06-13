<?php
session_start();
header('Content-Type: application/json');

// Solo usuarios logueados
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

include '../config/db.php';

$stmt = $conn->prepare("SELECT pelicula_id FROM mi_lista WHERE user_id = ?");
$stmt->execute([ $_SESSION['usuario_id'] ]);
$ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($ids);
