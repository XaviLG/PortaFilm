document.addEventListener("DOMContentLoaded", () => {
  fetch('/portaFilm/api/get_peliculas.php')
    .then(res => res.json())
    .then(peliculas => {
      const carousel = document.getElementById("recent-carousel");
      carousel.innerHTML = ''; // limpia cualquier placeholder
      peliculas.forEach(p => {
        const card = document.createElement('div');
        card.className = 'movie-card';

        // Imagen física en /assets/img/
        const img = new Image();
        img.src = p.portada;
        img.alt = p.titulo;
        card.appendChild(img);

        // Información
        const info = document.createElement('div');
        info.className = 'movie-info';
        info.innerHTML = `
          <span class="rating">⭐ ${p.media_puntuacion ?? 'N/A'}</span>
          <h4>${p.titulo}</h4>
          <button>+ Mi lista</button>
        `;
        card.appendChild(info);

        carousel.appendChild(card);
      });
    })
    .catch(err => console.error("Error cargando películas:", err));
});
