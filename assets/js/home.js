document.addEventListener("DOMContentLoaded", () => {
  // Helper que crea una tarjeta
  function makeCard(p) {
    const card = document.createElement("div");
    card.className = "movie-card";
    card.style.cursor = "pointer";

    const img = new Image();
    img.src = p.portada;
    img.alt = p.titulo;
    card.appendChild(img);

    const info = document.createElement("div");
    info.className = "movie-info";
    info.innerHTML = `
      <span class="rating">⭐ ${p.media_puntuacion ?? 'N/A'}</span>
      <h4>${p.titulo}</h4>
      <button>+ Mi lista</button>
    `;
    card.appendChild(info);

    card.addEventListener("click", () => {
      window.location.href = `/portaFilm/pages/peliculas.php?id=${p.id}`;
    });

    return card;
  }

  // 1) Agregadas recientemente
  fetch("/portaFilm/api/get_peliculas.php?limit=15")
    .then(r => r.json())
    .then(pelis => {
      console.log("Recientes:", pelis);
      const c = document.getElementById("recent-carousel");
      pelis.forEach(p => c.appendChild(makeCard(p)));
    })
    .catch(e => console.error(e));

  // 2) Mejor valoradas
  fetch("/portaFilm/api/get_peliculas.php?top=15")
    .then(r => r.json())
    .then(pelis => {
      console.log("Top:", pelis);
      const c = document.getElementById("top-rated-carousel");
      pelis.forEach(p => c.appendChild(makeCard(p)));
    })
    .catch(e => console.error(e));

  // 3) Por cada .carousel[data-genero]
  document.querySelectorAll(".carousel[data-genero]").forEach(car => {
    const gid = car.dataset.genero;
    fetch(`/portaFilm/api/get_peliculas.php?genero_id=${gid}&limit=15`)
      .then(r => r.json())
      .then(pelis => {
        console.log(`Género ${gid}:`, pelis);
        pelis.forEach(p => car.appendChild(makeCard(p)));
      })
      .catch(e => console.error(e));
  });
});
