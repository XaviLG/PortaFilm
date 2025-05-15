<?php
session_start();
/*
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}*/
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<div class="page-content">
  <!-- Carrusel de las películas recién añadidas -->
  <section class="movie-section">
    <h2>🎬 Agregadas recientemente</h2>
    <div class="carousel-container">
      <div class="carousel" id="recent-carousel"></div>
    </div>
  </section>

  <!-- Carrusel de las mejor valoradas -->
  <section class="movie-section">
    <h2>⭐ Mejor valoradas</h2>
    <div class="carousel-container">
      <div class="carousel" id="top-rated-carousel"></div>
    </div>
  </section>
</div>

<?php include '../includes/footer.php'; ?>

