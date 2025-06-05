document.addEventListener("DOMContentLoaded", () => {
  // Helper que crea una tarjeta de película
  function makeCard(p) {
    const card = document.createElement("div");
    card.className = "movie-card";
    card.style.cursor = "pointer";

    // --- Imagen ---
    const img = new Image();
    img.src = p.portada;
    img.alt = p.titulo;
    card.appendChild(img);

    // --- Información: estrellas, título y botón ---
    const info = document.createElement("div");
    info.className = "movie-info";
    info.innerHTML = `
      <span class="rating">⭐ ${p.media_puntuacion ?? 'N/A'}</span>
      <h4>${p.titulo}</h4>
      <button>+ Mi lista</button>
    `;
    card.appendChild(info);

    // Al hacer clic, vamos al detalle de la película
    card.addEventListener("click", () => {
      window.location.href = `/portaFilm/pages/peliculas.php?id=${p.id}`;
    });

    return card;
  }

  // ===== 1) Cargar “Agregadas recientemente” =====
  fetch("/portaFilm/api/get_peliculas.php?limit=15")
    .then(r => r.json())
    .then(pelis => {
      console.log("Recientes:", pelis);
      const container = document.getElementById("recent-carousel");
      //  └─ Vaciar contenido previo
      container.innerHTML = "";

      pelis.forEach(p => {
        container.appendChild(makeCard(p));
      });
    })
    .catch(e => console.error(e));

  // ===== 2) Cargar “Mejor valoradas” =====
  fetch("/portaFilm/api/get_peliculas.php?top=15")
    .then(r => r.json())
    .then(pelis => {
      console.log("Top:", pelis);
      const container = document.getElementById("top-rated-carousel");
      //  └─ Vaciar contenido previo
      container.innerHTML = "";

      pelis.forEach(p => {
        container.appendChild(makeCard(p));
      });
    })
    .catch(e => console.error(e));

  // ===== 3) Cargar carruseles por cada género =====
  document.querySelectorAll(".carousel[data-genero]").forEach(carouselEl => {
    const gid = carouselEl.dataset.genero;
    fetch(`/portaFilm/api/get_peliculas.php?genero_id=${gid}&limit=15`)
      .then(r => r.json())
      .then(pelis => {
        console.log(`Género ${gid}:`, pelis);
        //  └─ Vaciar contenido previo
        carouselEl.innerHTML = "";

        pelis.forEach(p => {
          carouselEl.appendChild(makeCard(p));
        });
      })
      .catch(e => console.error(e));
  });
});
