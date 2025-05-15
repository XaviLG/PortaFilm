<?php
header('Content-Type: application/json');
include '../config/db.php';

try {
    $stmt = $conn->query("
        SELECT
            p.id               AS id,
            p.titulo           AS titulo,
            p.portada          AS portada,
            ROUND(AVG(v.puntuacion),1) AS media_puntuacion
        FROM peliculas p
        LEFT JOIN valoracion v ON p.id = v.pelicula_id
        GROUP BY p.id
        ORDER BY p.id DESC
        LIMIT 15
    ");

    $pelis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ajusta la URL de la portada para que apunte a tu carpeta assets/img
    foreach ($pelis as &$p) {
        $p['portada'] = '/PortaFilm/assets/img/' . $p['portada'];
    }

    echo json_encode($pelis);
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Error al obtener las películas: ' . $e->getMessage()
    ]);
}

