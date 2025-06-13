document.addEventListener('DOMContentLoaded', () => {
  const container   = document.querySelector('.star-rating');
  if (!container) return;

  const stars       = Array.from(container.querySelectorAll('.star'));
  const peliculaId  = container.dataset.pelicula;
  let   userScore   = window.userScore || 0;

  //Pinta n estrellas
  function paint(n) {
    stars.forEach(s => {
      s.classList.toggle('filled', Number(s.dataset.score) <= n);
    });
  }

  //Hover
  stars.forEach(star => {
    star.addEventListener('mouseenter', () => paint(Number(star.dataset.score)));
  });
  container.addEventListener('mouseleave', () => paint(userScore));

  //si ya votaste, muestralo
  if (userScore > 0) paint(userScore);

  stars.forEach(star => {
    star.addEventListener('click', () => {
      const score = Number(star.dataset.score);

      if (!window.isLogged) {
        return window.location.href = '/portaFilm/pages/login.php';
      }

      fetch('/portaFilm/api/rate.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({pelicula_id: peliculaId, score})
      })
      .then(res => {
        if (res.status === 401) throw new Error('Debes iniciar sesión');
        if (!res.ok)     throw new Error('Error al valorar');
        return res.json();
      })
      .then(json => {
        if (json.success) {
          //actualiza puntuación propia y repinta
          userScore = score;
          paint(score);
          //actualiza la media en pantalla
          const avgEl = document.querySelector('.avg-rating');
          if (avgEl && json.new_average !== undefined) {
            avgEl.textContent = `Valoración media: ${json.new_average} / 10`;
          }
        } else {
          throw new Error(json.error || 'Error desconocido');
        }
      })
      .catch(err => {
        console.error(err);
      });
    });
  });
});