document.addEventListener("DOMContentLoaded", () => {
  fetch('/portaFilm/api/get_peliculas.php')
    .then(r => r.json())
    .then(peliculas => {
      const carousel = document.getElementById('recent-carousel');
      carousel.innerHTML = '';
      peliculas.forEach(p => {
        const card = document.createElement('div');
        card.className = 'movie-card';
        card.style.cursor = 'pointer';

        // Imagen
        const img = new Image();
        img.src = p.portada;
        img.alt = p.titulo;
        card.appendChild(img);

        // Info
        const info = document.createElement('div');
        info.className = 'movie-info';
        info.innerHTML = `
          <span class="rating">⭐ ${p.media_puntuacion ?? 'N/A'}</span>
          <h4>${p.titulo}</h4>
          <button>+ Mi lista</button>
        `;
        card.appendChild(info);

        // Al hacer clic, vamos a la página detalle con ?id=...
        card.addEventListener('click', () => {
          window.location.href = `/portaFilm/pages/peliculas.php?id=${p.id}`;
        });

        carousel.appendChild(card);
      });
    })
    .catch(console.error);
});