<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<div class="page-content">
<div class="login-container">
    <h2>Iniciar sesión</h2>
    <form action="../controllers/loginController.php" method="POST" class="login-form">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="register-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</div>
</div>
<?php include '../includes/footer.php'; ?>


