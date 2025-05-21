<?php
session_start();
include '../config/db.php';

// 1) Carga todos los géneros
$gStmt   = $conn->query("SELECT id,nombre FROM generos ORDER BY nombre");
$generos = $gStmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/nav.php';
?>
<div class="page-content">

  <section class="movie-section">
  <h2>🎬 Agregadas recientemente</h2>
  <div class="carousel-container">
    <div class="carousel" id="recent-carousel"></div>
  </div>
</section>

<section class="movie-section">
  <h2>⭐ Mejor valoradas</h2>
  <div class="carousel-container">
    <div class="carousel" id="top-rated-carousel"></div>
  </div>
</section>

<?php foreach($generos as $g): ?>
  <section class="movie-section">
    <h2>🎞 <?=htmlspecialchars($g['nombre'])?></h2>
    <div class="carousel-container">
      <div 
        class="carousel" 
        id="genre-<?=$g['id']?>-carousel" 
        data-genero="<?=$g['id']?>"
      ></div>
    </div>
  </section>
<?php endforeach; ?>


</div>

<script src="/portaFilm/assets/js/home.js"></script>
<?php include '../includes/footer.php'; ?>