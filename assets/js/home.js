document.addEventListener("DOMContentLoaded", () => {
  let myListSet = new Set();

  //Primero cargamos la lista del usuario
  fetch("/portaFilm/api/get_my_list.php")
    .then(res => res.json())
    .then(ids => {
      myListSet = new Set(ids);
      initCarousels();
    })
    .catch(err => {
      console.error("Error cargando mi lista:", err);
      initCarousels();
    });

  function initCarousels() {
    //Helper que crea una tarjeta
    function makeCard(p) {
      const card = document.createElement("div");
      card.className = "movie-card";
      card.style.cursor = "pointer";

      // Imagen
      const img = new Image();
      img.src = p.portada;
      img.alt = p.titulo;
      card.appendChild(img);

      //Info + boton
      const info = document.createElement("div");
      info.className = "movie-info";

      //Rating y titulo
      info.innerHTML = `
        <span class="rating">⭐ ${p.media_puntuacion ?? 'N/A'}</span>
        <h4>${p.titulo}</h4>
      `;

      //Boton Mi Lista
      const btn = document.createElement("button");
      btn.className = "btn-mi-lista";
      btn.style.marginTop = "8px";

      if (myListSet.has(p.id)) {
        btn.textContent = "✓ En lista";
        btn.disabled = true;
      } else {
        btn.textContent = "+ Mi lista";
      }

      info.appendChild(btn);
      card.appendChild(info);

      //clic tarjeta
      card.addEventListener("click", ev => {
        if (ev.target === btn) return;
        window.location.href = `/portaFilm/pages/peliculas.php?id=${p.id}`;
      });

      //clic boton
      btn.addEventListener("click", ev => {
        ev.stopPropagation();
        toggleMyList(p.id, btn);
      });

      return card;
    }

    function toggleMyList(peliculaId, buttonEl) {
      fetch(`/portaFilm/api/add_to_list.php`, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `pelicula_id=${peliculaId}`
      })
      .then(r => r.json())
      .then(data => {
        if (!data.success) {
          if (data.error === "Unauthorized") {
            window.location.href = "/portaFilm/pages/login.php";
          } else {
            alert("Error: " + data.error);
          }
          return;
        }
        if (data.action === "added") {
          buttonEl.textContent = "✓ En lista";
          buttonEl.disabled = true;
          myListSet.add(peliculaId);
        } else {
          buttonEl.textContent = "+ Mi lista";
          buttonEl.disabled = false;
          myListSet.delete(peliculaId);
        }
      })
      .catch(err => console.error("add_to_list error:", err));
    }

    //Agregadas recientemente
    fetch("/portaFilm/api/get_peliculas.php?limit=15")
      .then(r => r.json())
      .then(pelis => {
        const c = document.getElementById("recent-carousel");
        pelis.forEach(p => c.appendChild(makeCard(p)));
      })
      .catch(console.error);

    //Mejor valoradas
    fetch("/portaFilm/api/get_peliculas.php?top=15")
      .then(r => r.json())
      .then(pelis => {
        const c = document.getElementById("top-rated-carousel");
        pelis.forEach(p => c.appendChild(makeCard(p)));
      })
      .catch(console.error);

    // Por genero
    document.querySelectorAll(".carousel[data-genero]").forEach(car => {
      const gid = car.dataset.genero;
      fetch(`/portaFilm/api/get_peliculas.php?genero_id=${gid}&limit=15`)
        .then(r => r.json())
        .then(pelis => {
          pelis.forEach(p => car.appendChild(makeCard(p)));
        })
        .catch(console.error);
    });
  }
});
