// /PortaFilm/assets/js/home.js
document.addEventListener("DOMContentLoaded", () => {
  // Helper: crea una tarjeta de película
  function makeCard(p) {
    const card = document.createElement("div");
    card.className = "movie-card";
    card.style.cursor = "pointer";

    // 1) Imagen
    const img = new Image();
    img.src = p.portada;
    img.alt = p.titulo;
    card.appendChild(img);

    // 2) Contenedor de info
    const info = document.createElement("div");
    info.className = "movie-info";

    //  2a) Rating + Título
    const ratingSpan = document.createElement("span");
    ratingSpan.className = "rating";
    ratingSpan.textContent = `⭐ ${p.media_puntuacion ?? 'N/A'}`;
    info.appendChild(ratingSpan);

    const titleEl = document.createElement("h4");
    titleEl.textContent = p.titulo;
    info.appendChild(titleEl);

    //  2b) Botón “+ Mi lista”
    const btn = document.createElement("button");
    btn.textContent = "+ Mi lista";
    btn.className = "btn-mi-lista";
    // añadimos margen para que no choque con el click del card
    btn.style.marginTop = "8px";
    info.appendChild(btn);

    card.appendChild(info);

    // 3) Hacer clic en la tarjeta completa → ir a detalle
    card.addEventListener("click", (ev) => {
      // Si el clic viene del botón “+ Mi lista”, no navegamos a la ficha:
      if (ev.target === btn) return;
      window.location.href = `/portaFilm/pages/peliculas.php?id=${p.id}`;
    });

    // 4) Evento “click” en el botón “+ Mi lista”
    btn.addEventListener("click", (ev) => {
      ev.stopPropagation(); // evitar que “card” interprete el click
      toggleMyList(p.id, btn);
    });

    return card;
  }

  // Función que llama al endpoint para agregar/quitar de “Mi lista”
  function toggleMyList(peliculaId, buttonEl) {
    fetch(`/portaFilm/api/add_to_list.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `pelicula_id=${peliculaId}`
    })
    .then(r => r.json())
    .then(data => {
      if (!data.success) {
        // Si no está logueado, redirigir al login
        if (data.error === "Unauthorized") {
          window.location.href = "/portaFilm/pages/login.php";
        } else {
          alert("Error: " + data.error);
        }
        return;
      }

      // Cambiamos el texto del botón según la acción
      if (data.action === "added") {
        buttonEl.textContent = "✓ En lista";
        buttonEl.disabled = true; 
        // (opcional: deshabilitar para no duplicar el click)
      } else if (data.action === "removed") {
        buttonEl.textContent = "+ Mi lista";
        buttonEl.disabled = false;
      }
    })
    .catch(err => {
      console.error("add_to_list error:", err);
    });
  }

  // 1) Cargar películas “Agregadas recientemente”
  fetch("/portaFilm/api/get_peliculas.php?limit=15")
    .then(res => res.json())
    .then(pelis => {
      const container = document.getElementById("recent-carousel");
      // ─────────────────────────────────────────────────────────────
      // ¡LIMPIAMOS el contenido previo para evitar duplicados!
      container.innerHTML = "";
      // ─────────────────────────────────────────────────────────────
      pelis.forEach(p => {
        container.appendChild(makeCard(p));
      });
    })
    .catch(console.error);

  // 2) Cargar películas “Mejor valoradas”
  fetch("/portaFilm/api/get_peliculas.php?top=15")
    .then(res => res.json())
    .then(pelis => {
      const container = document.getElementById("top-rated-carousel");
      // ─────────────────────────────────────────────────────────────
      // Limpiamos antes de volver a rellenar:
      container.innerHTML = "";
      // ─────────────────────────────────────────────────────────────
      pelis.forEach(p => {
        container.appendChild(makeCard(p));
      });
    })
    .catch(console.error);

  // 3) Para cada carrusel por género
  document.querySelectorAll(".carousel[data-genero]").forEach(car => {
    const gid = car.dataset.genero;
    fetch(`/portaFilm/api/get_peliculas.php?genero_id=${gid}&limit=15`)
      .then(res => res.json())
      .then(pelis => {
        // ─────────────────────────────────────────────────────────────
        // Limpiamos este carrusel de género antes de agregar tarjetas:
        car.innerHTML = "";
        // ─────────────────────────────────────────────────────────────
        pelis.forEach(p => {
          car.appendChild(makeCard(p));
        });
      })
      .catch(console.error);
  });

});
