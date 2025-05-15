document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.star-rating');
  if (!container) return;

  const stars = Array.from(container.querySelectorAll('.star'));
  const peliculaId = container.dataset.pelicula;

  // Marca n estrellas (añade/remueve .filled)
  function paint(n) {
    stars.forEach(s => {
      s.classList.toggle('filled', Number(s.dataset.score) <= n);
    });
  }

  // Manejo de hover
  stars.forEach(star => {
    star.addEventListener('mouseenter', () => {
      paint(Number(star.dataset.score));
    });
  });
  container.addEventListener('mouseleave', () => paint(0));

  // Manejo de click
  stars.forEach(star => {
    star.addEventListener('click', () => {
      const score = Number(star.dataset.score);

      if (!window.isLogged) {
        // Redirige al login
        return window.location.href = '/portaFilm/pages/login.php';
      }

      // Envía la valoración
      fetch('/portaFilm/api/rate.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({pelicula_id: peliculaId, score})
      })
      .then(res => {
        if (res.status === 401) throw new Error('Debes iniciar sesión');
        if (!res.ok) throw new Error('Error al valorar');
        return res.json();
      })
      .then(json => {
        if (json.success) {
          paint(score);
          alert('¡Gracias por tu valoración!');
        } else {
          throw new Error(json.error || 'Error desconocido');
        }
      })
      .catch(err => alert(err.message));
    });
  });
});