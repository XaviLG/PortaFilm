<?php
// /PortaFilm/pages/lista.php
session_start();
include '../config/db.php';

// 1) Si no está logueado, redirigir a login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['usuario_id'];

// 2) Recuperar las películas de “Mi lista” de este usuario
$stmt = $conn->prepare("
    SELECT p.id, p.titulo, p.portada
    FROM peliculas p
    INNER JOIN mi_lista ml ON p.id = ml.pelicula_id
    WHERE ml.user_id = ?
    ORDER BY ml.id DESC
");
$stmt->execute([ $userId ]);
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="page-content">
  <section class="movie-section">
    <h2>📋 Mi lista de películas</h2>
    <?php if (empty($peliculas)): ?>
      <p>Aún no has agregado ninguna película a tu lista.</p>
    <?php else: ?>
      <div class="carousel-container">
        <div class="carousel" id="mi-lista-carousel">
          <?php foreach($peliculas as $p): ?>
            <div class="movie-card" style="cursor:pointer;">
              <!-- Imagen de portada -->
              <img src="/portaFilm/assets/img/<?php echo htmlspecialchars($p['portada']); ?>"
                   alt="<?php echo htmlspecialchars($p['titulo']); ?>" />
              <!-- Info mínima -->
              <div class="movie-info">
                <h4><?php echo htmlspecialchars($p['titulo']); ?></h4>
                <button class="btn-remove-lista" data-id="<?php echo $p['id']; ?>">
                  ✕ Quitar
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<!-- Script para quitar elementos directamente desde esta página -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Para cada botón “✕ Quitar”, añadimos evento
    document.querySelectorAll(".btn-remove-lista").forEach(btn => {
      btn.addEventListener("click", (e) => {
        e.stopPropagation();
        const peliculaId = btn.dataset.id;
        fetch("/portaFilm/api/add_to_list.php?pelicula_id=" + peliculaId, {
          method: "POST"
        })
        .then(res => res.json())
        .then(data => {
          if (data.success && data.action === "removed") {
            // Eliminar la tarjeta del DOM
            btn.closest(".movie-card").remove();
          } else {
            alert("Error al quitar de la lista");
          }
        })
        .catch(err => console.error(err));
      });
    });

    // Si clicas fuera del botón, ir al detalle de la película
    document.querySelectorAll(".movie-card").forEach(card => {
      card.addEventListener("click", (e) => {
        // Si se clicó en el botón “Quitar”, no redirigimos
        if (e.target.classList.contains("btn-remove-lista")) return;
        const pid = e.currentTarget.querySelector(".btn-remove-lista").dataset.id;
        window.location.href = "/portaFilm/pages/peliculas.php?id=" + pid;
      });
    });
  });
</script>

<?php include '../includes/footer.php'; ?>
