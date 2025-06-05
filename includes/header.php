<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>portaFilm</title>
    <link rel="stylesheet" href="/portaFilm/assets/css/style.css">
    <script src="/portaFilm/assets/js/main.js"></script>
</head>
<body>

<header class="main-header">
    <div class="header-left">
        <a href="/portaFilm/pages/home.php" class="logo">portaFilm</a>
        <button class="menu-btn">☰ Menú</button>
    </div>

    <div class="header-center">
        <input type="text" placeholder="Buscar en portaFilm..." class="search-input">
        <button class="search-btn">🔍</button>
    </div>

    <div class="header-right">
        <a href="/portaFilm/pages/lista.php">Lista</a>
        <?php if (isset($_SESSION['usuario_id'])): ?>
    <a href="/portaFilm/pages/home.php">Mi cuenta</a>
    <a href="/portaFilm/controllers/logout.php">Cerrar sesión</a>

    <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
        <a href="/portaFilm/pages/admin_add.php">Añadir película</a>
    <?php endif; ?>
    <?php else: ?>
        <a href="/portaFilm/pages/login.php">Iniciar sesión</a>
    <?php endif; ?>


        <select class="lang-select">
            <option>ES</option>
            <option>EN</option>
        </select>
    </div>
</header>
