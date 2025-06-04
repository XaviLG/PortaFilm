<?php
// controllers/adminEditController.php
session_start();
include '../config/db.php';

// 1) Comprobar sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

// 2) Sólo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/admin_edit.php');
    exit;
}

// 3) Recoger y sanitizar campos
$id         = isset($_POST['pelicula_id']) ? (int) $_POST['pelicula_id'] : 0;
$titulo     = trim($_POST['titulo'] ?? '');
$sipnopsis  = trim($_POST['sipnopsis'] ?? '');
$anho       = trim($_POST['anho'] ?? '');
$duracion   = trim($_POST['duracion'] ?? '');
$director   = trim($_POST['director'] ?? '');
$pais       = trim($_POST['pais'] ?? '');
$genero_ids = $_POST['genero_ids'] ?? []; // array de IDs (puede venir vacío)

// 4) Validar campos obligatorios
$errores = [];
if ($id <= 0)              $errores[] = "ID de película inválido.";
if ($titulo === '')        $errores[] = "El campo Título es obligatorio.";
if ($sipnopsis === '')     $errores[] = "El campo Sinopsis es obligatorio.";
if ($anho === '')          $errores[] = "El campo Año es obligatorio.";
if ($duracion === '')      $errores[] = "El campo Duración es obligatorio.";
if ($director === '')      $errores[] = "El campo Director es obligatorio.";
if ($pais === '')          $errores[] = "El campo País es obligatorio.";
if (empty($genero_ids))    $errores[] = "Debes seleccionar al menos un género.";

// 5) Si hay errores, redirigir con mensajes
if (count($errores) > 0) {
    $qs = http_build_query(['error' => implode(' | ', $errores), 'id' => $id]);
    header("Location: ../pages/admin_edit.php?$qs");
    exit;
}

// 6) Empezar transacción (opcional pero recomendable)
$conn->beginTransaction();

try {
    // 7) Gestionar posible nueva portada
    $nuevoFilename = null;
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        // a) Generar nombre único
        $ext         = pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION);
        $nuevoFilename = uniqid('img_') . '.' . $ext;
        $destino     = __DIR__ . '/../assets/img/' . $nuevoFilename;

        // b) Mover el archivo
        if (!move_uploaded_file($_FILES['portada']['tmp_name'], $destino)) {
            throw new Exception("Error al mover la nueva portada.");
        }

        // c) Opcional: borrar la imagen antigua para no acumular ficheros (si existe)
        $antiguaPortada = $conn->prepare("SELECT portada FROM peliculas WHERE id = ?");
        $antiguaPortada->execute([$id]);
        $oldName = $antiguaPortada->fetchColumn();
        if ($oldName) {
            $oldFile = __DIR__ . '/../assets/img/' . $oldName;
            if (is_file($oldFile)) {
                @unlink($oldFile);
            }
        }
    }

    // 8) Hacer UPDATE en la tabla películas
    $fieldsSQL = "
      titulo    = ?,
      sipnopsis = ?,
      anho      = ?,
      duracion  = ?,
      director  = ?,
      pais      = ?
    ";
    $params    = [
        $titulo,
        $sipnopsis,
        $anho,
        $duracion,
        $director,
        $pais,
        $id
    ];

    // Si hay portada nueva, añadimos ese campo
    if ($nuevoFilename !== null) {
        $fieldsSQL .= ", portada = ?";
        array_splice($params, count($params) - 1, 0, $nuevoFilename);
        // Ahora $params pasa a ser: [titulo, sipnopsis, anho, duracion, director, pais, nuevoFilename, id]
    }

    $sqlUpdate = "UPDATE peliculas SET $fieldsSQL WHERE id = ?";
    $stmtUpd   = $conn->prepare($sqlUpdate);
    $stmtUpd->execute($params);

    // 9) Sincronizar tabla pivot pelicula_genero
    // 9.1) Borrar viejas relaciones
    $delStmt  = $conn->prepare("DELETE FROM pelicula_genero WHERE pelicula_id = ?");
    $delStmt->execute([$id]);

    // 9.2) Insertar nuevas relaciones
    $insPg    = $conn->prepare("
        INSERT INTO pelicula_genero (pelicula_id, genero_id)
        VALUES (?, ?)
    ");
    foreach ($genero_ids as $gid) {
        $insPg->execute([$id, (int)$gid]);
    }

    // 10) Confirmar transacción
    $conn->commit();

    // 11) Redirigir con éxito
    header("Location: ../pages/admin_edit.php?success=1&id=$id");
    exit;

} catch (Exception $e) {
    // Si algo falla, revertir cambios y redirigir con error
    $conn->rollBack();
    $msg = urlencode("Error al actualizar: " . $e->getMessage());
    header("Location: ../pages/admin_edit.php?error=$msg&id=$id");
    exit;
}
