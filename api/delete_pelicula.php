<?php
session_start();
include '../config/db.php';

// 1) Sólo admin puede borrar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol']!=='admin') {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success'=>false,'error'=>'Unauthorized']);
    exit;
}

// 2) Debe venir por POST y con ID válido
if ($_SERVER['REQUEST_METHOD']!=='POST' || !isset($_POST['id'])) {
    header('Location: ../pages/index.php');
    exit;
}
$id = (int)$_POST['id'];
if ($id <= 0) {
    header('Location: ../pages/index.php');
    exit;
}

try {
    // 3) (Opcional) recupera el nombre del archivo para borrarlo del disco
    $f = $conn->prepare("SELECT portada FROM peliculas WHERE id = ?");
    $f->execute([$id]);
    if ($row = $f->fetch(PDO::FETCH_ASSOC)) {
        $file = __DIR__.'/../assets/img/'.$row['portada'];
        if (is_file($file)) unlink($file);
    }

    // 4) Borrar dependencias en orden: pivot y valoraciones
    $conn->beginTransaction();
    $conn->prepare("DELETE FROM pelicula_genero WHERE pelicula_id = ?")
         ->execute([$id]);
    $conn->prepare("DELETE FROM valoracion        WHERE pelicula_id = ?")
         ->execute([$id]);
    $conn->prepare("DELETE FROM comentarios       WHERE pelicula_id = ?")
         ->execute([$id]);
    // 5) Por último, borrar la propia película
    $conn->prepare("DELETE FROM peliculas         WHERE id = ?")
         ->execute([$id]);
    $conn->commit();

    // 6) Redirigir de vuelta al home con un mensaje
    header('Location: ../pages/home.php?deleted=1');
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    header('Location: ../pages/peliculas.php?id='.$id.'&error=delete');
    exit;
}
