<?php
session_start();
include '../config/db.php';

//Solo admin puede borrar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol']!=='admin') {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success'=>false,'error'=>'Unauthorized']);
    exit;
}

//Debe venir por POST y con ID valido
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
    // Recupera el nombre del archivo para borrarlo del disco
    $f = $conn->prepare("SELECT portada FROM peliculas WHERE id = ?");
    $f->execute([$id]);
    if ($row = $f->fetch(PDO::FETCH_ASSOC)) {
        $file = __DIR__.'/../assets/img/'.$row['portada'];
        if (is_file($file)) unlink($file);
    }

    //Borrar dependencias en orden: pivot y valoraciones
    $conn->beginTransaction();
    $conn->prepare("DELETE FROM pelicula_genero WHERE pelicula_id = ?")
         ->execute([$id]);
    $conn->prepare("DELETE FROM valoracion        WHERE pelicula_id = ?")
         ->execute([$id]);
    $conn->prepare("DELETE FROM comentarios       WHERE pelicula_id = ?")
         ->execute([$id]);
    // Borrar la propia pelicula
    $conn->prepare("DELETE FROM peliculas         WHERE id = ?")
         ->execute([$id]);
    $conn->commit();

    //Redirigir de vuelta al home
    header('Location: ../pages/home.php?deleted=1');
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    header('Location: ../pages/peliculas.php?id='.$id.'&error=delete');
    exit;
}
