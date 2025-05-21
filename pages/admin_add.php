<?php
session_start();

// 1) Conexión a la base de datos
include '../config/db.php';   // <-- Asegúrate de que esta ruta es correcta

// 2) Comprobamos si está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// 3) Comprobamos si es admin
if ($_SESSION['usuario_rol'] !== 'admin') {
    echo "Acceso denegado. Esta sección es solo para administradores.";
    exit();
}

// 4) Ahora sí podemos usar $conn para cargar géneros
$gStmt   = $conn->query("SELECT id, nombre FROM generos ORDER BY nombre");
$generos = $gStmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="page-content">
    <div class="form-container">
        <h2>Añadir nueva película</h2>
        <?php if (!empty($_GET['success'])): ?>
        <div class="alert success">¡Película guardada correctamente!</div>
            <?php elseif (!empty($_GET['error'])): ?>
                <div class="alert error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form action="../controllers/adminAddController.php" method="POST" enctype="multipart/form-data">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" required>

            <label for="duracion">Duración</label>
            <input type="text" name="duracion" id="duracion" required>

            <label for="director">Director</label>
            <input type="text" name="director" id="director" required>

            <label for="pais">País</label>
            <input type="text" name="pais" id="pais" required>


            <label for="sipnopsis">Sinopsis</label>
            <textarea name="sipnopsis" rows="4" required></textarea>

            <label for="anho">Año</label>
            <input type="text" name="anho" required>

            <label>Géneros</label>
                <div class="checkbox-group">
                    <?php foreach($generos as $g): ?>
                        <label>
                            <input 
                                type="checkbox" 
                                name="genero_ids[]" 
                                value="<?= $g['id'] ?>"
                            > <?= htmlspecialchars($g['nombre']) ?>
                            </label><br>
                    <?php endforeach; ?>
                </div>

            <label for="portada">Portada (JPG, PNG)</label>
            <input type="file" name="portada" accept="image/*" required>

            <button type="submit">Guardar película</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
