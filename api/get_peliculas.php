<?php
// Asegurarnos de NO imprimir nada antes del JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
include '../config/db.php';

try {
    //Leer y sanear parametros
    $limit     = isset($_GET['limit'])     ? (int) $_GET['limit']     : 15;
    $top       = isset($_GET['top'])       ? (bool)$_GET['top']       : false;
    $genero_id = isset($_GET['genero_id']) ? (int) $_GET['genero_id'] : null;

    //Preparar WHERE dinamico
    $whereClauses = [];
    $params       = [];

    if ($genero_id) {
        $whereClauses[]   = "pg.genero_id = ?";
        $params[]         = $genero_id;
    }
    $whereSql = $whereClauses
        ? 'WHERE ' . implode(' AND ', $whereClauses)
        : '';

    $orderBy = $top
        ? "ORDER BY media_puntuacion DESC"
        : "ORDER BY p.id DESC";

    $sql = "
      SELECT
        p.id,
        p.titulo,
        p.portada,
        ROUND(AVG(v.puntuacion),1) AS media_puntuacion,
        GROUP_CONCAT(DISTINCT g.nombre ORDER BY g.nombre SEPARATOR ', ') AS generos
      FROM peliculas p
      LEFT JOIN pelicula_genero pg ON p.id = pg.pelicula_id
      LEFT JOIN generos g          ON pg.genero_id = g.id
      LEFT JOIN valoracion v       ON p.id = v.pelicula_id
      $whereSql
      GROUP BY p.id
      $orderBy
      LIMIT {$limit}
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $pelis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Ajustar rutas de portada
    foreach ($pelis as &$p) {
      $p['portada'] = '/portaFilm/assets/img/' . $p['portada'];
    }

    //Devolver JSON limpio
    echo json_encode($pelis);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
      'error' => 'Error en la consulta: ' . $e->getMessage()
    ]);
}

exit;
