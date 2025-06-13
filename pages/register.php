<?php 
// pages/register.php
session_start();
include '../includes/header.php';
include '../includes/nav.php';

// Capturamos parámetros de mensaje
$error   = $_GET['error']   ?? '';
$success = isset($_GET['success']);
?>

<div class="page-content">
  <div class="register-container">
    <h2>Crear cuenta</h2>

    <?php if ($success): ?>
      <div class="alert success">
        ✅ Registro completado. Ya puedes iniciar sesión.
      </div>
    <?php elseif ($error): ?>
      <div class="alert error">
        ⚠️ <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

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



