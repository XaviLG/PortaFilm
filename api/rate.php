<?php
session_start();
header('Content-Type: application/json');
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    exit(json_encode(['error'=>'Método no permitido']));
}
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    exit(json_encode(['error'=>'No autorizado']));
}

$input      = json_decode(file_get_contents('php://input'), true);
$pid        = intval($input['pelicula_id'] ?? 0);
$score      = intval($input['score']       ?? 0);
$user_id    = $_SESSION['usuario_id'];

if ($pid < 1 || $score < 1 || $score > 10) {
    http_response_code(400);
    exit(json_encode(['error'=>'Datos inválidos']));
}

try {
    // insert o update
    $exists = $conn->prepare("
      SELECT 1 FROM valoracion 
      WHERE user_id=? AND pelicula_id=?
    ");
    $exists->execute([$user_id, $pid]);
    if ($exists->fetch()) {
        $upd = $conn->prepare("
          UPDATE valoracion 
          SET puntuacion=? 
          WHERE user_id=? AND pelicula_id=?
        ");
        $upd->execute([$score, $user_id, $pid]);
    } else {
        $ins = $conn->prepare("
          INSERT INTO valoracion (user_id,pelicula_id,puntuacion)
          VALUES (?,?,?)
        ");
        $ins->execute([$user_id, $pid, $score]);
    }

    // calcular nueva media
    $avgStmt = $conn->prepare("
      SELECT ROUND(AVG(puntuacion),1) 
      FROM valoracion 
      WHERE pelicula_id=?
    ");
    $avgStmt->execute([$pid]);
    $new_avg = $avgStmt->fetchColumn();

    echo json_encode([
      'success'      => true,
      'new_average'  => $new_avg
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}