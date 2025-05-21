<?php
session_start();
include '../config/db.php';

// 1) Sólo admin y sólo POST
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/admin_add.php');
    exit;
}

// 2) Recoger y sanitizar campos
$titulo      = trim($_POST['titulo']    ?? '');
$sipnopsis   = trim($_POST['sipnopsis'] ?? '');
$anho        = trim($_POST['anho']      ?? '');
$duracion    = trim($_POST['duracion']  ?? '');
$director    = trim($_POST['director']  ?? '');
$pais        = trim($_POST['pais']      ?? '');
$genero_ids  = $_POST['genero_ids'] ?? [];  // array de IDs

// 3) Validaciones
$errores = [];
if ($titulo === '')      $errores[] = "El campo Título es obligatorio.";
if ($sipnopsis === '')   $errores[] = "El campo Sinopsis es obligatorio.";
if ($anho === '')        $errores[] = "El campo Año es obligatorio.";
if ($duracion === '')    $errores[] = "El campo Duración es obligatorio.";
if ($director === '')    $errores[] = "El campo Director es obligatorio.";
if ($pais === '')        $errores[] = "El campo País es obligatorio.";
if (empty($genero_ids))  $errores[] = "Debes seleccionar al menos un género.";
if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== UPLOAD_ERR_OK) {
    $errores[] = "Debe subir una imagen de portada válida.";
}

if (count($errores) > 0) {
    $qs = http_build_query(['error' => implode(' | ', $errores)]);
    header("Location: ../pages/admin_add.php?$qs");
    exit;
}

// 4) Subir la imagen
$ext      = pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION);
$filename = uniqid('img_') . '.' . $ext;
$destino  = __DIR__ . '/../assets/img/' . $filename;

if (!move_uploaded_file($_FILES['portada']['tmp_name'], $destino)) {
    $msg = urlencode("Error al mover la portada.");
    header("Location: ../pages/admin_add.php?error=$msg");
    exit;
}

// 5) Insertar película y géneros
try {
    // 5.1 Insertamos la peli
    $sql = "INSERT INTO peliculas
      (titulo, portada, sipnopsis, anho, duracion, director, pais)
     VALUES
      (:titulo, :portada, :sipnopsis, :anho, :duracion, :director, :pais)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':titulo'    => $titulo,
      ':portada'   => $filename,
      ':sipnopsis' => $sipnopsis,
      ':anho'      => $anho,
      ':duracion'  => $duracion,
      ':director'  => $director,
      ':pais'      => $pais
    ]);
    $newPeliId = $conn->lastInsertId();

    // 5.2 Insertamos los géneros en la tabla pivot
    $insertPG = $conn->prepare("
      INSERT INTO pelicula_genero (pelicula_id, genero_id)
      VALUES (:peli, :gen)
    ");
    foreach ($genero_ids as $gid) {
        $insertPG->execute([
          ':peli' => $newPeliId,
          ':gen'  => (int)$gid
        ]);
    }

    header('Location: ../pages/admin_add.php?success=1');
    exit;

} catch (PDOException $e) {
    $msg = urlencode("Error al guardar: " . $e->getMessage());
    header("Location: ../pages/admin_add.php?error=$msg");
    exit;
}
