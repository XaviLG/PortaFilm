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
    header('Location: home.php');
    exit;
}

// 2) Construcción del SQL (solo por título)
if ($context === 'lista' && $userId) {
    $sql = "
      SELECT p.id, p.titulo, p.portada,
             ROUND(AVG(v.puntuacion),1) AS media_puntuacion
      FROM peliculas p
      INNER JOIN mi_lista ml    ON ml.pelicula_id = p.id
      LEFT  JOIN valoracion v   ON v.pelicula_id = p.id
      WHERE ml.user_id = ?
        AND p.titulo LIKE ?
      GROUP BY p.id
      ORDER BY ml.id DESC
      LIMIT 50
    ";
    $params = [$userId, "%$q%"];
} else {
    $sql = "
      SELECT p.id, p.titulo, p.portada,
             ROUND(AVG(v.puntuacion),1) AS media_puntuacion
      FROM peliculas p
      LEFT JOIN valoracion v ON v.pelicula_id = p.id
      WHERE p.titulo LIKE ?
      GROUP BY p.id
      ORDER BY p.titulo ASC
      LIMIT 50
    ";
    $params = ["%$q%"];
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-content">
  <section class="movie-section">
    <h2>
      🔎 Resultados para «<?= htmlspecialchars($q, ENT_QUOTES) ?>»
      <?php if ($context === 'lista' && $userId): ?> – en tu lista<?php endif; ?>
    </h2>

    <?php if (empty($results)): ?>
    <p>No se encontraron películas que coincidan.</p>
    <?php else: ?>
        <div class="results-grid">
            <?php foreach ($results as $p): ?>
                <div
                    class="movie-card"
                    onclick="window.location='/portaFilm/pages/peliculas.php?id=<?= $p['id'] ?>';"
                >
                    <img
                    src="/portaFilm/assets/img/<?= htmlspecialchars($p['portada'], ENT_QUOTES) ?>"
                    alt="<?= htmlspecialchars($p['titulo'], ENT_QUOTES) ?>"
                />
                <div class="movie-info">
                    <span class="rating">⭐ <?= $p['media_puntuacion'] ?? 'N/A' ?></span>
                    <h4><?= htmlspecialchars($p['titulo'], ENT_QUOTES) ?></h4>
                    <button type="button">Ver ficha</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
  </section>
</div>

<?php include '../includes/footer.php'; ?>
