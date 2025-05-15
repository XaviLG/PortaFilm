<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol']!=='admin') {
    header('HTTP/1.1 403 Forbidden'); exit;
}
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    header('Location: ../pages/admin_add.php'); exit;
}

// Recoger y sanitizar
$titulo    = trim($_POST['titulo']  ?? '');
$sipno     = trim($_POST['sipnopsis']??'');
$anho      = trim($_POST['anho']    ?? '');
$genero    = trim($_POST['genero']  ?? '');
$duracion  = trim($_POST['duracion']?? '');
$director  = trim($_POST['director']?? '');
$pais      = trim($_POST['pais']    ?? '');

$errores = [];
foreach (['titulo'=>'Título','sipnopsis'=>'Sinopsis','anho'=>'Año','genero'=>'Género',
          'duracion'=>'Duración','director'=>'Director','pais'=>'País'] 
         as $campo=>$label) {
    if (trim($_POST[$campo]??'')==='') {
        $errores[] = "El campo $label es obligatorio.";
    }
}
if (!isset($_FILES['portada']) || $_FILES['portada']['error']!==UPLOAD_ERR_OK) {
    $errores[] = "Debe subir una imagen de portada válida.";
}

if (count($errores)>0) {
    $qs = http_build_query(['error'=>implode(' | ',$errores)]);
    header("Location: ../pages/admin_add.php?$qs"); exit;
}

//  --- A partir de aquí guardamos fichero en lugar de base64 ---

// 1) Preparamos nombre único
$ext       = pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION);
$filename  = uniqid('img_').'.'.$ext;
$destino   = __DIR__ . '/../assets/img/' . $filename;

// 2) Movemos el fichero subido
if (!move_uploaded_file($_FILES['portada']['tmp_name'], $destino)) {
    $msg = urlencode("Error al mover la portada.");
    header("Location: ../pages/admin_add.php?error=$msg");
    exit;
}

// 3) Insertamos en BD sólo el nombre de archivo
try {
    $sql = "INSERT INTO peliculas
      (titulo, portada, sipnopsis, anho, genero, duracion, director, pais)
     VALUES
      (:titulo, :portada, :sipnopsis, :anho, :genero, :duracion, :director, :pais)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':titulo'    => $titulo,
      ':portada'   => $filename,
      ':sipnopsis' => $sipno,
      ':anho'      => $anho,
      ':genero'    => $genero,
      ':duracion'  => $duracion,
      ':director'  => $director,
      ':pais'      => $pais
    ]);
    header('Location: ../pages/admin_add.php?success=1'); exit;
} catch (PDOException $e) {
    $msg = urlencode("Error al guardar: ".$e->getMessage());
    header("Location: ../pages/admin_add.php?error=$msg"); exit;
}
