<?php
session_start();
include '../config/db.php';

//Si no esta logueado, redirigir a login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['usuario_id'];

if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
    header("Location: /portaFilm/pages/buscar.php?context=lista&q=" . urlencode($q));
    exit;
}

//Recuperar las peliculas de Mi lista de este usuario
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
    <div class="search-in-list" style="margin-bottom: 20px;">
      <form action="/portaFilm/pages/lista.php" method="get" class="search-form" style="display:flex; gap:8px;">
        <input
          type="text"
          name="q"
          placeholder="Buscar en mi lista..."
          value="<?php echo htmlspecialchars($_GET['q'] ?? '') ?>"
          style="flex:1; padding:5px; border-radius:4px; border:1px solid #ccc;"
        />
        <button type="submit" style="padding:5px 10px; border:none; background:#007BFF; color:#fff; border-radius:4px;">
          🔍
        </button>
      </form>
    </div>

    <h2>📋 Mi lista de películas</h2>

    <?php if (empty($peliculas)): ?>
      <p>Aún no has agregado ninguna película a tu lista.</p>
    <?php else: ?>
      <div class="my-list-container" style="display:flex; overflow-x:auto; gap:15px; padding:10px 0;">
        <?php foreach($peliculas as $p): ?>
          <div class="movie-card" style="position:relative; flex:0 0 auto; width:160px; background:#1c1c1c; border-radius:10px; overflow:hidden; color:#fff;">
            <img 
              src="/portaFilm/assets/img/<?php echo htmlspecialchars($p['portada']); ?>" 
              alt="<?php echo htmlspecialchars($p['titulo']); ?>" 
              style="width:100%; height:230px; object-fit:cover;"
            />
            <div class="movie-info" style="padding:10px;">
              <h4 style="margin:5px 0; font-size:14px;"><?php echo htmlspecialchars($p['titulo']); ?></h4>
              <button 
                class="btn-remove-lista" 
                data-id="<?php echo $p['id']; ?>"
                style="margin-top:8px; width:100%; padding:5px; background:#007BFF; color:#fff; border:none; border-radius:8px; cursor:pointer;"
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
    //Quitar de la lista
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

    //Clic en la tarjeta, ir a detalle
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
