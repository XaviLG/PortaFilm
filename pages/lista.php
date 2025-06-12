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
      <div class="my-list-container">
        <?php foreach($peliculas as $p): ?>
          <div class="movie-card">
            <!-- Imagen de portada -->
            <img 
              src="/portaFilm/assets/img/<?php echo htmlspecialchars($p['portada']); ?>" 
              alt="<?php echo htmlspecialchars($p['titulo']); ?>" 
            />

            <!-- Info mínima y botón de quitar -->
            <div class="movie-info">
              <h4><?php echo htmlspecialchars($p['titulo']); ?></h4>
              <button 
                class="btn-remove-lista" 
                data-id="<?php echo $p['id']; ?>"
              >
                ✕ Quitar
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Quitar de la lista
    document.querySelectorAll(".btn-remove-lista").forEach(btn => {
      btn.addEventListener("click", async e => {
        e.stopPropagation();
        const peliculaId = btn.dataset.id;
        try {
          const res = await fetch("/portaFilm/api/add_to_list.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `pelicula_id=${peliculaId}`
          });
          const data = await res.json();
          if (data.success && data.action === "removed") {
            btn.closest(".movie-card").remove();
          } else {
            alert("No se pudo quitar de la lista.");
          }
        } catch (err) {
          console.error(err);
        }
      });
    });

    // Click en la tarjeta → detalle
    document.querySelectorAll(".movie-card").forEach(card => {
      card.addEventListener("click", e => {
        if (e.target.classList.contains("btn-remove-lista")) return;
        const pid = card.querySelector(".btn-remove-lista").dataset.id;
        window.location.href = `/portaFilm/pages/peliculas.php?id=${pid}`;
      });
    });
  });
</script>

<?php include '../includes/footer.php'; ?>
