<?php 
// pages/login.php
session_start();
include '../includes/header.php';
include '../includes/nav.php';

$error      = $_GET['error']      ?? '';
$registered = isset($_GET['registered']);
?>
<div class="page-content">
  <div class="login-container">
    <h2>Iniciar sesión</h2>

    <?php if ($registered): ?>
      <div class="alert success">
        ✅ Cuenta creada con éxito. Por favor, inicia sesión.
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert error">
        ⚠️ <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="../controllers/loginController.php" method="POST" class="login-form">
      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Entrar</button>
    </form>

    <p class="register-link">
      ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
    </p>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
