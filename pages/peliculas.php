<?php
session_start();
include '../config/db.php';

// 1) Recoger el id de la URL y validarlo
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../index.php');
    exit();
}

// 2) Consulta a la base de datos
$stmt = $conn->prepare("
    SELECT titulo, portada, sipnopsis, anho, genero, duracion, director, pais
    FROM peliculas
    WHERE id = ?
");
$stmt->execute([$id]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$pelicula) {
    echo "Película no encontrada.";
    exit();
}

include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="page-content">
  <div class="detail-container">
    <div class="detail-poster">
      <img src="/portaFilm/assets/img/<?php echo htmlspecialchars($pelicula['portada']); ?>"
           alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
    </div>
    <div class="detail-info">
      <h1><?php echo htmlspecialchars($pelicula['titulo']); ?></h1>
      <div class="info-item"><strong>Año:</strong> <?php echo htmlspecialchars($pelicula['anho']); ?></div>
      <div class="info-item"><strong>Duración:</strong> <?php echo htmlspecialchars($pelicula['duracion']); ?></div>
      <div class="info-item"><strong>País:</strong> <?php echo htmlspecialchars($pelicula['pais']); ?></div>
      <div class="info-item"><strong>Género:</strong> <?php echo htmlspecialchars($pelicula['genero']); ?></div>
      <div class="info-item"><strong>Director:</strong> <?php echo htmlspecialchars($pelicula['director']); ?></div>
      <div class="info-item"><strong>Sinopsis:</strong>
        <p><?php echo nl2br(htmlspecialchars($pelicula['sipnopsis'])); ?></p>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
