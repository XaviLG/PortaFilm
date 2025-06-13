<?php
header('Content-Type: application/json');
session_start();
include '../config/db.php';

//Debe estar logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([ 'success' => false, 'error' => 'Unauthorized' ]);
    http_response_code(401);
    exit;
}

$userId = (int) $_SESSION['usuario_id'];

//Recoger ID de la pelicula
$peliculaId = 0;
if (isset($_POST['pelicula_id'])) {
    $peliculaId = (int) $_POST['pelicula_id'];
} elseif (isset($_GET['pelicula_id'])) {
    $peliculaId = (int) $_GET['pelicula_id'];
}

if ($peliculaId <= 0) {
    echo json_encode([ 'success' => false, 'error' => 'Missing pelicula_id' ]);
    exit;
}

//Comprobar si ya existe en la lista
try {
    //Buscar si ya existe
    $check = $conn->prepare("
        SELECT id 
        FROM mi_lista 
        WHERE user_id = ? AND pelicula_id = ?
    ");
    $check->execute([ $userId, $peliculaId ]);
    $exists = $check->fetchColumn();

    if ($exists) {
        //Si ya existe eliminar
        $del = $conn->prepare("
            DELETE FROM mi_lista 
            WHERE user_id = ? AND pelicula_id = ?
        ");
        $del->execute([ $userId, $peliculaId ]);
        echo json_encode([ 
            'success' => true, 
            'action'  => 'removed' 
        ]);
        exit;
    } else {
        // Si no existe insertar
        $ins = $conn->prepare("
            INSERT INTO mi_lista (user_id, pelicula_id)
            VALUES (?, ?)
        ");
        $ins->execute([ $userId, $peliculaId ]);
        echo json_encode([ 
            'success' => true, 
            'action'  => 'added' 
        ]);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode([ 
        'success' => false, 
        'error'   => 'DB error: ' . $e->getMessage() 
    ]);
    http_response_code(500);
    exit;
}
