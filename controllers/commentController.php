<?php
session_start();
include '../config/db.php';

//Comprobar que hay una sesion valida
if (!isset($_SESSION['usuario_id'])) {
    //Si no está logueado, redirigimos a login
    header('Location: ../pages/login.php');
    exit;
}

//Verificar que llega el ID de la pelicula
$pelicula_id = isset($_POST['pelicula_id']) 
    ? (int) $_POST['pelicula_id'] 
    : (isset($_GET['pelicula_id']) ? (int) $_GET['pelicula_id'] : 0);

if ($pelicula_id <= 0) {
    header('Location: ../index.php');
    exit;
}

//Recoger y sanitizar el texto del comentario
$texto = trim($_POST['texto'] ?? '');
if ($texto === '') {
    header("Location: ../pages/peliculas.php?id=$pelicula_id");
    exit;
}

//Insertar el comentario en la tabla comentarios
try {
    $stmt = $conn->prepare("
        INSERT INTO comentarios (user_id, pelicula_id, texto, `date`)
        VALUES (:user_id, :pelicula_id, :texto, :fecha)
    ");

    //Fecha actual en formato YYYY-MM-DD
    $hoy = date('Y-m-d');

    $stmt->execute([
        ':user_id'     => $_SESSION['usuario_id'],
        ':pelicula_id' => $pelicula_id,
        ':texto'       => $texto,
        ':fecha'       => $hoy
    ]);

} catch (PDOException $e) {
    header("Location: ../pages/peliculas.php?id=$pelicula_id");
    exit;
}

header("Location: ../pages/peliculas.php?id=$pelicula_id");
exit;
