<?php
// /pages/buscar.php
session_start();
include '../config/db.php';
include '../includes/header.php';
include '../includes/nav.php';

// 1) Recogemos y saneamos la query
$q       = trim($_GET['q'] ?? '');
$context = $_GET['context'] ?? ''; // si viene "lista", filtramos por la lista del usuario
$userId  = $_SESSION['usuario_id'] ?? null;

if ($q === '') {
    // Si no hay término de búsqueda, volvemos al home
    header('Location: home.php');
    exit;
}

// 2) Construimos SQL y parámetros según contexto
$params = [];
if ($context === 'lista' && $userId) {
    // Búsqueda DENTRO de la lista del usuario
    $sql = "
      SELECT p.id, p.titulo, p.portada,
             ROUND(AVG(v.puntuacion),1) AS media_puntuacion
      FROM peliculas p
      INNER JOIN mi_lista ml    ON ml.pelicula_id = p.id
      LEFT  JOIN valoracion v   ON v.pelicula_id = p.id
      WHERE ml.user_id = ?
        AND (p.titulo LIKE ? OR p.sipnopsis LIKE ?)
      GROUP BY p.id
      ORDER BY ml.id DESC
      LIMIT 50
    ";
    // 1er parámetro user_id, luego dos veces %q%
    $params = [$userId, "%$q%", "%$q%"];
} else {
    // Búsqueda GLOBAL en todas las películas
    $sql = "
      SELECT p.id, p.titulo, p.portada,
             ROUND(AVG(v.puntuacion),1) AS media_puntuacion
      FROM peliculas p
      LEFT JOIN valoracion v ON v.pelicula_id = p.id
      WHERE p.titulo   LIKE ?
         OR p.sipnopsis LIKE ?
      GROUP BY p.id
      ORDER BY p.titulo ASC
      LIMIT 50
    ";
    $params = ["%$q%", "%$q%"];
}

// 3) Ejecutamos la consulta
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-content">
  <section class="movie-section">
    <h2>
      🔎 Resultados para «<?= htmlspecialchars($q, ENT_QUOTES) ?>»
      <?php if ($context === 'lista' && $userId): ?>
        – en tu lista
      <?php endif; ?>
    </h2>

    <?php if (empty($results)): ?>
      <p>No se encontraron películas que coincidan.</p>
    <?php else: ?>
      <div class="carousel-container">
        <div class="carousel">
          <?php foreach ($results as $p): ?>
            <div class="movie-card" style="cursor:pointer;">
              <img
                src="/portaFilm/assets/img/<?= htmlspecialchars($p['portada'], ENT_QUOTES) ?>"
                alt="<?= htmlspecialchars($p['titulo'], ENT_QUOTES) ?>"
              />
              <div class="movie-info">
                <span class="rating">⭐ <?= $p['media_puntuacion'] ?? 'N/A' ?></span>
                <h4><?= htmlspecialchars($p['titulo'], ENT_QUOTES) ?></h4>
                <button onclick="location.href='/portaFilm/pages/peliculas.php?id=<?= $p['id'] ?>'">
                  Ver ficha
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<?php include '../includes/footer.php'; ?>
