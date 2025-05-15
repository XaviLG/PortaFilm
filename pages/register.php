<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<div class="page-content">
<div class="register-container">
    <h2>Crear cuenta</h2>
    <form action="../controllers/registerController.php" method="POST" class="register-form">
        <label for="name">Nombre completo</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Registrarse</button>
    </form>
</div>
</div>

<?php include '../includes/footer.php'; ?>


