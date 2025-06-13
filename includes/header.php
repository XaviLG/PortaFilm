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
    </div>

    <div class="header-center">
        <?php
        //Detectamos el nombre del script actual
        $current = basename($_SERVER['PHP_SELF']);
        //Solo mostramos este buscador si NO estamos en lista.php
        if ($current !== 'lista.php'): ?>
            <form action="/portaFilm/pages/buscar.php" method="get" class="search-form">
                <input
                    type="text"
                    name="q"
                    placeholder="Buscar en portaFilm..."
                    value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
                />
                <button type="submit">🔍</button>
            </form>
        <?php endif; ?>
    </div>

     <div class="header-right">
        <?php 
            //Solo mostramos Lista a usuarios no-admin:
            if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] !== 'admin'): 
            ?>
            <a href="/portaFilm/pages/lista.php">Lista</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="/portaFilm/controllers/logout.php">Cerrar sesión</a>
            <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                <a href="/portaFilm/pages/admin_add.php">Añadir película</a>
            <?php endif; ?>
            <?php else: ?>
            <a href="/portaFilm/pages/login.php">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</header>
