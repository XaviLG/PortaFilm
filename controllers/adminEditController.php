<?php
session_start();
include '../config/db.php';

//Comprobar sesion y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

//Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/admin_edit.php');
    exit;
}

//Recoger y sanitizar campos
$id         = isset($_POST['pelicula_id']) ? (int) $_POST['pelicula_id'] : 0;
$titulo     = trim($_POST['titulo'] ?? '');
$sipnopsis  = trim($_POST['sipnopsis'] ?? '');
$anho       = trim($_POST['anho'] ?? '');
$duracion   = trim($_POST['duracion'] ?? '');
$director   = trim($_POST['director'] ?? '');
$pais       = trim($_POST['pais'] ?? '');
$genero_ids = $_POST['genero_ids'] ?? [];

//Validar campos obligatorios
$errores = [];
if ($id <= 0)              $errores[] = "ID de película inválido.";
if ($titulo === '')        $errores[] = "El campo Título es obligatorio.";
if ($sipnopsis === '')     $errores[] = "El campo Sinopsis es obligatorio.";
if ($anho === '')          $errores[] = "El campo Año es obligatorio.";
if ($duracion === '')      $errores[] = "El campo Duración es obligatorio.";
if ($director === '')      $errores[] = "El campo Director es obligatorio.";
if ($pais === '')          $errores[] = "El campo País es obligatorio.";
if (empty($genero_ids))    $errores[] = "Debes seleccionar al menos un género.";

if (count($errores) > 0) {
    $qs = http_build_query(['error' => implode(' | ', $errores), 'id' => $id]);
    header("Location: ../pages/admin_edit.php?$qs");
    exit;
}

//Empezar transaccion
$conn->beginTransaction();

try {
    //Gestionar posible nueva portada
    $nuevoFilename = null;
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        //Generar nombre unico
        $ext         = pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION);
        $nuevoFilename = uniqid('img_') . '.' . $ext;
        $destino     = __DIR__ . '/../assets/img/' . $nuevoFilename;

        //Mover el archivo
        if (!move_uploaded_file($_FILES['portada']['tmp_name'], $destino)) {
            throw new Exception("Error al mover la nueva portada.");
        }

        //Borrar la imagen antigua para no acumular ficheros (si existe)
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

    //Hacer UPDATE en la tabla peliculas
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

    //Si hay portada nueva, añadimos ese campo
    if ($nuevoFilename !== null) {
        $fieldsSQL .= ", portada = ?";
        array_splice($params, count($params) - 1, 0, $nuevoFilename);
    }

    $sqlUpdate = "UPDATE peliculas SET $fieldsSQL WHERE id = ?";
    $stmtUpd   = $conn->prepare($sqlUpdate);
    $stmtUpd->execute($params);

    //Borrar viejas relaciones
    $delStmt  = $conn->prepare("DELETE FROM pelicula_genero WHERE pelicula_id = ?");
    $delStmt->execute([$id]);

    //Insertar nuevas relaciones
    $insPg    = $conn->prepare("
        INSERT INTO pelicula_genero (pelicula_id, genero_id)
        VALUES (?, ?)
    ");
    foreach ($genero_ids as $gid) {
        $insPg->execute([$id, (int)$gid]);
    }

    //Confirmar transaccion
    $conn->commit();

    header("Location: ../pages/admin_edit.php?success=1&id=$id");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    $msg = urlencode("Error al actualizar: " . $e->getMessage());
    header("Location: ../pages/admin_edit.php?error=$msg&id=$id");
    exit;
}
