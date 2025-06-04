<?php
// controllers/commentController.php
session_start();
include '../config/db.php';

// 1) Comprobar que hay una sesión válida
if (!isset($_SESSION['usuario_id'])) {
    // Si no está logueado, redirigimos a login (puedes ajustar la ruta si tu login.php está en otra carpeta)
    header('Location: ../pages/login.php');
    exit;
}

// 2) Verificar que llega el ID de la película
$pelicula_id = isset($_POST['pelicula_id']) 
    ? (int) $_POST['pelicula_id'] 
    : (isset($_GET['pelicula_id']) ? (int) $_GET['pelicula_id'] : 0);

if ($pelicula_id <= 0) {
    // Si no indicaron bien la película, lo mandamos al inicio
    header('Location: ../index.php');
    exit;
}

// 3) Recoger y sanitizar el texto del comentario
$texto = trim($_POST['texto'] ?? '');
if ($texto === '') {
    // Si está vacío, volvemos a la ficha sin insertar (podrías añadir un mensaje de error)
    header("Location: ../pages/peliculas.php?id=$pelicula_id");
    exit;
}

// 4) Insertar el comentario en la tabla comentarios
try {
    $stmt = $conn->prepare("
        INSERT INTO comentarios (user_id, pelicula_id, texto, `date`)
        VALUES (:user_id, :pelicula_id, :texto, :fecha)
    ");

    // Fecha actual en formato YYYY-MM-DD
    $hoy = date('Y-m-d');

    $stmt->execute([
        ':user_id'     => $_SESSION['usuario_id'],
        ':pelicula_id' => $pelicula_id,
        ':texto'       => $texto,
        ':fecha'       => $hoy
    ]);

} catch (PDOException $e) {
    // Si ocurre un error, redirigimos de igual forma (o podrías pasar ?error=…)
    header("Location: ../pages/peliculas.php?id=$pelicula_id");
    exit;
}

// 5) Una vez insertado, volvemos a la ficha de la película (para que cargue de nuevo con el comentario)
header("Location: ../pages/peliculas.php?id=$pelicula_id");
exit;
