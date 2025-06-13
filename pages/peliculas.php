<?php
session_start();
include '../config/db.php';

//Recoger y validar ID de pelicula
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../index.php');
    exit;
}

//Obtener datos basicos de la pelicula
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

//Obtener generos asociados
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

//Obtener valoracion media
$avgStmt = $conn->prepare("
    SELECT ROUND(AVG(puntuacion),1) AS avg_rating
    FROM valoracion
    WHERE pelicula_id = ?
");
$avgStmt->execute([$id]);
$avg = $avgStmt->fetchColumn();

//Obtener tu puntuacion si estas logueado
$userScore = 0;
if (isset($_SESSION['usuario_id'])) {
    $usrStmt = $conn->prepare("
        SELECT puntuacion
        FROM valoracion
        WHERE user_id = ? AND pelicula_id = ?
    ");
    $usrStmt->execute([ $_SESSION['usuario_id'], $id ]);
    $userScore = (int)$usrStmt->fetchColumn();
}

include '../includes/header.php';
include '../includes/nav.php';
?>

<?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
  <div style="text-align: right; margin: 20px 0;">
    <a 
      href="/portaFilm/pages/admin_edit.php?id=<?php echo $id; ?>" 
      style="
        display: inline-block;
        background-color: #FFD700;
        color: #000;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        margin-right: 8px;
      "
    >
      ✎ Editar película
    </a>

    <form 
      action="/portaFilm/api/delete_pelicula.php" 
      method="POST" 
      style="display:inline"
      onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta película?');"
    >
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <button 
        type="submit" 
        style="
          background-color: #E02424;
          color: #fff;
          border: none;
          padding: 8px 12px;
          border-radius: 4px;
          cursor: pointer;
          font-weight: bold;
        "
      >
        🗑 Eliminar película
      </button>
    </form>
  </div>
<?php endif; ?>


<div class="page-content">
  <div class="detail-container">
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
          if ($avg) {
            echo "Valoración media: {$avg} / 10";
          } else {
            echo "Sin valoraciones aún";
          }
        ?>
      </div>
    </div>
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
      <div class="info-item">
        <strong>Géneros:</strong>
        <?php
          echo count($listaGeneros)
            ? htmlspecialchars(implode(', ', $listaGeneros))
            : '—';
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

  <!-- Sección de Comentarios -->
  <div class="comments-section">
    <h2>Comentarios</h2>

    <?php
    //Cargar comentarios
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

    <?php if (empty($comentarios)): ?>
      <p class="no-comments">Aún no hay comentarios.</p>
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

    <!-- Formulario para dejar comentario -->
    <?php if (isset($_SESSION['usuario_id'])): ?>
      <div class="comment-form">
        <h3>Deja tu comentario</h3>
        <form 
          action="/portaFilm/controllers/commentController.php" 
          method="POST"
        >
          <input type="hidden" name="pelicula_id" value="<?php echo $id; ?>">
          <textarea 
            name="texto" 
            rows="4" 
            placeholder="Escribe tu comentario..." 
            required
          ></textarea>
          <button type="submit" class="btn btn-submit">
            Publicar comentario
          </button>
        </form>
      </div>
    <?php else: ?>
      <p class="must-login">
        Debes <a href="/portaFilm/pages/login.php">iniciar sesión</a> para comentar.
      </p>
    <?php endif; ?>
  </div>
</div>

<script>
  window.isLogged  = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
  window.userScore = <?php echo json_encode($userScore); ?>;
</script>
<script src="/portaFilm/assets/js/rating.js"></script>

<?php include '../includes/footer.php'; ?>
