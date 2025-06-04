<?php
// pages/peliculas.php
session_start();
include '../config/db.php';

// 1) Recoger y validar ID de película
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../index.php');
    exit;
}

// 2) Obtener datos básicos de la película
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

// 3) Obtener géneros asociados (tabla pivot)
$gStmt = $conn->prepare("
    SELECT g.nombre
    FROM generos g
    JOIN pelicula_genero pg 
      ON g.id = pg.genero_id
    WHERE pg.pelicula_id = ?
    ORDER BY g.nombre
");
$gStmt->execute([$id]);
$listaGeneros = $gStmt->fetchAll(PDO::FETCH_COLUMN);
// $listaGeneros ahora es un array de nombres de géneros, p.ej. ['Acción','Comedia']

// 4) Obtener valoración media
$avgStmt = $conn->prepare("
    SELECT ROUND(AVG(puntuacion),1) AS avg_rating
    FROM valoracion
    WHERE pelicula_id = ?
");
$avgStmt->execute([$id]);
$avg = $avgStmt->fetchColumn(); 
// $avg contendrá, por ejemplo, 7.8 o NULL si no hay valoraciones

// 5) Obtener tu puntuación si estás logueado
$userScore = 0;
if (isset($_SESSION['usuario_id'])) {
    $usrStmt = $conn->prepare("
        SELECT puntuacion
        FROM valoracion
        WHERE user_id = ? AND pelicula_id = ?
    ");
    $usrStmt->execute([ $_SESSION['usuario_id'], $id ]);
    $userScore = (int)$usrStmt->fetchColumn();
    // Si el usuario ya ha votado, $userScore es de 1 a 10; si no, se queda en 0
}

include '../includes/header.php';
include '../includes/nav.php';
?>

<?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
  <div style="text-align: right; margin-bottom: 10px;">
    <a 
      href="/portaFilm/pages/admin_edit.php?id=<?php echo $id; ?>" 
      class="btn btn-edit"
      style="
        display: inline-block;
        background-color: #FFD700; /* dorado */
        color: #000;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9em;
      "
    >
      ✎ Editar película
    </a>
  </div>
<?php endif; ?>


<div class="page-content">
  <div class="detail-container">

    <!-- LEFT COLUMN: póster + estrellas + media -->
    <div class="detail-left">
      <div class="detail-poster">
        <img 
          src="/portaFilm/assets/img/<?php echo htmlspecialchars($pelicula['portada']); ?>"
          alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>"
        >
      </div>

      <!-- 5) Estrellas para votar -->
      <div class="star-rating" data-pelicula="<?php echo $id; ?>">
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <span class="star" data-score="<?php echo $i; ?>">★</span>
        <?php endfor; ?>
      </div>

      <!-- 4) Mostrar la valoración media -->
      <div class="avg-rating">
        <?php
          if ($avg) {
            // Si existe un promedio, lo mostramos con una decimal
            echo "Valoración media: {$avg} / 10";
          } else {
            echo "Sin valoraciones aún";
          }
        ?>
      </div>
    </div>

    <!-- RIGHT COLUMN: toda la información de la película -->
    <div class="detail-info">
      <h1><?php echo htmlspecialchars($pelicula['titulo']); ?></h1>

      <div class="info-item">
        <strong>Año:</strong> <?php echo htmlspecialchars($pelicula['anho']); ?>
      </div>
      <div class="info-item">
        <strong>Duración:</strong> <?php echo htmlspecialchars($pelicula['duracion']); ?>
      </div>
      <div class="info-item">
        <strong>País:</strong> <?php echo htmlspecialchars($pelicula['pais']); ?>
      </div>

      <!-- 3) Mostrar los géneros concatenados -->
      <div class="info-item">
        <strong>Géneros:</strong>
        <?php
          if (count($listaGeneros) > 0) {
            // Unimos con coma y espacio, p.ej. "Acción, Comedia, Terror"
            echo htmlspecialchars(implode(', ', $listaGeneros));
          } else {
            echo '—';
          }
        ?>
      </div>

      <div class="info-item">
        <strong>Director:</strong> <?php echo htmlspecialchars($pelicula['director']); ?>
      </div>
      <div class="info-item">
        <strong>Sinopsis:</strong>
        <p><?php echo nl2br(htmlspecialchars($pelicula['sipnopsis'])); ?></p>
      </div>
    </div>

  </div>
  <div class="comments-section">
    <h2>Comentarios</h2>

    <?php
    // 1) Consultar todos los comentarios para esta película
    $cStmt = $conn->prepare("
      SELECT c.texto, c.date, u.name 
      FROM comentarios c
      JOIN `user` u ON c.user_id = u.id
      WHERE c.pelicula_id = ?
      ORDER BY c.date DESC, c.id DESC
    ");
    $cStmt->execute([$id]);
    $comentarios = $cStmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (count($comentarios) === 0): ?>
      <p class="no-comments">Aún no hay comentarios. ¡Sé el primero en comentar!</p>
    <?php else: ?>
      <ul class="comment-list">
        <?php foreach ($comentarios as $com): ?>
          <li class="comment-item">
            <div class="comment-meta">
              <strong><?php echo htmlspecialchars($com['name']); ?></strong>
              <span class="comment-date">
                <?php echo date('d/m/Y', strtotime($com['date'])); ?>
              </span>
            </div>
            <div class="comment-text">
              <?php echo nl2br(htmlspecialchars($com['texto'])); ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
        <?php if (isset($_SESSION['usuario_id'])): ?>
      <div class="comment-form">
        <h3>Deja tu comentario</h3>
        <form 
          action="/portaFilm/controllers/commentController.php" 
          method="POST"
        >
          <input 
            type="hidden" 
            name="pelicula_id" 
            value="<?php echo $id; ?>"
          >

          <textarea 
            name="texto" 
            rows="4" 
            placeholder="Escribe tu comentario aquí..." 
            required
          ></textarea>

          <button type="submit" class="btn btn-submit">
            Publicar comentario
          </button>
        </form>
      </div>
    <?php else: ?>
      <p class="must-login">
        Debes <a href="/portaFilm/pages/login.php">iniciar sesión</a> para dejar un comentario.
      </p>
    <?php endif; ?>

  </div><!-- /.comments-section -->
  <!-- ==================================================== -->

</div>

<!-- 5) Pasamos variables a rating.js -->
<script>
  // ¿Está el usuario logueado? rating.js las usará para redirigir a login si hace click sin estarlo
  window.isLogged  = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
  // Si ya había votado, userScore es su puntuación; si no, 0
  window.userScore = <?php echo json_encode($userScore); ?>;
</script>
<script src="/portaFilm/assets/js/rating.js"></script>

<?php include '../includes/footer.php'; ?>
