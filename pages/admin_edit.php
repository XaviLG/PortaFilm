<?php
// pages/admin_edit.php
session_start();
include '../config/db.php';

// 1) Solo POST/GET admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

// 2) Verificar que tenemos un ID válido por GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../index.php');
    exit;
}

// 3) Obtener datos de la película
$stmt = $conn->prepare("
    SELECT titulo, portada, sipnopsis, anho, duracion, director, pais
    FROM peliculas
    WHERE id = ?
");
$stmt->execute([$id]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$pelicula) {
    echo "Película no encontrada.";
    exit;
}

// 4) Obtener géneros ya asignados a esta película (pivot)
$pgStmt = $conn->prepare("
    SELECT genero_id
    FROM pelicula_genero
    WHERE pelicula_id = ?
");
$pgStmt->execute([$id]);
$genAsignados = $pgStmt->fetchAll(PDO::FETCH_COLUMN); 
// $genAsignados es un array de IDs (por ejemplo [1,4,7])

// 5) Cargar TODAS las filas de generos para checkboxes
$gStmt   = $conn->query("SELECT id, nombre FROM generos ORDER BY nombre");
$generos = $gStmt->fetchAll(PDO::FETCH_ASSOC);

// 6) Ahora mostramos el formulario pre‐relleno
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="page-content">
  <div class="form-container">
    <h2>Editar película: <?php echo htmlspecialchars($pelicula['titulo']); ?></h2>

    <?php if (!empty($_GET['success'])): ?>
      <div class="alert success">¡Datos actualizados correctamente!</div>
    <?php elseif (!empty($_GET['error'])): ?>
      <div class="alert error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form 
      action="../controllers/adminEditController.php" 
      method="POST" 
      enctype="multipart/form-data"
    >
      <!-- Campo oculto con el ID de la película -->
      <input type="hidden" name="pelicula_id" value="<?php echo $id; ?>">

      <label for="titulo">Título</label>
      <input 
        type="text" 
        name="titulo" 
        id="titulo" 
        value="<?php echo htmlspecialchars($pelicula['titulo']); ?>" 
        required
      >

      <label for="duracion">Duración</label>
      <input 
        type="text" 
        name="duracion" 
        id="duracion" 
        value="<?php echo htmlspecialchars($pelicula['duracion']); ?>" 
        required
      >

      <label for="director">Director</label>
      <input 
        type="text" 
        name="director" 
        id="director" 
        value="<?php echo htmlspecialchars($pelicula['director']); ?>" 
        required
      >

      <label for="pais">País</label>
      <input 
        type="text" 
        name="pais" 
        id="pais" 
        value="<?php echo htmlspecialchars($pelicula['pais']); ?>" 
        required
      >

      <label for="sipnopsis">Sinopsis</label>
      <textarea 
        name="sipnopsis" 
        id="sipnopsis" 
        rows="4" 
        required
      ><?php echo htmlspecialchars($pelicula['sipnopsis']); ?></textarea>

      <label for="anho">Año</label>
      <input 
        type="text" 
        name="anho" 
        id="anho" 
        value="<?php echo htmlspecialchars($pelicula['anho']); ?>" 
        required
      >

      <!-- Checkbox múltiple de géneros -->
      <label>Géneros</label>
      <div class="checkbox-group">
        <?php foreach($generos as $g): ?>
          <label>
            <input
              type="checkbox"
              name="genero_ids[]"
              value="<?php echo $g['id']; ?>"
              <?php 
                // Si ya está asignado, marcamos “checked”
                if (in_array($g['id'], $genAsignados, true)) {
                  echo 'checked';
                }
              ?>
            >
            <?php echo htmlspecialchars($g['nombre']); ?>
          </label>
          <br>
        <?php endforeach; ?>
      </div>

      <!-- Mostrar la portada actual y permitir subir una nueva -->
      <label>Portada actual</label>
      <div class="current-poster">
        <img 
          src="/portaFilm/assets/img/<?php echo htmlspecialchars($pelicula['portada']); ?>" 
          alt="Portada actual" 
          style="max-width: 200px; display:block; margin-bottom:10px;"
        >
        <small>Si subes un archivo nuevo, reemplazará la portada.</small>
      </div>

      <label for="portada">Portada (JPG, PNG) opcional</label>
      <input 
        type="file" 
        name="portada" 
        id="portada" 
        accept="image/*"
      >

      <br>
      <button type="submit">Guardar cambios</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
