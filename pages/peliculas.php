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

// 3) Obtener valoración media
$avgStmt = $conn->prepare("
  SELECT ROUND(AVG(puntuacion),1) 
    AS avg_rating 
  FROM valoracion 
  WHERE pelicula_id = ?
");
$avgStmt->execute([$id]);
$avg = $avgStmt->fetchColumn();

// 4) Obtener tu puntuación si estás logueado
$userScore = 0;
if (isset($_SESSION['usuario_id'])) {
    $usrStmt = $conn->prepare("
      SELECT puntuacion 
      FROM valoracion 
      WHERE user_id = ? AND pelicula_id = ?
    ");
    $usrStmt->execute([$_SESSION['usuario_id'], $id]);
    $userScore = (int)$usrStmt->fetchColumn();
}

include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="page-content">
  <div class="detail-container">

    <!--  LEFT COLUMN: poster arriba y estrellas debajo -->
    <div class="detail-left">
      <div class="detail-poster">
        <img 
          src="/portaFilm/assets/img/<?php echo htmlspecialchars($pelicula['portada']); ?>" 
          alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>"
        >
      </div>

      <div class="star-rating" data-pelicula="<?php echo $id; ?>">
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <span class="star" data-score="<?php echo $i; ?>">★</span>
        <?php endfor; ?>
      </div>
      <div class="avg-rating">
      <?php 
        echo $avg 
          ? "Valoración media: $avg / 10" 
          : "Sin valoraciones aún"; 
      ?>
    </div>
    </div>

    <!--  RIGHT COLUMN: toda la información -->
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

<!-- Indicador de sesión para rating.js -->
<script>
  window.isLogged = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
  window.userScore  = <?php echo json_encode($userScore); ?>;
</script>
<!-- Lógica de hover/click en las estrellas -->
<script src="/portaFilm/assets/js/rating.js"></script>

<?php include '../includes/footer.php'; ?>
