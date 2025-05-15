<?php
session_start();
include '../config/db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email && $password) {
    $stmt = $conn->prepare("SELECT u.id, u.name, u.password, u.rol, r.name AS rol_nombre
                            FROM user u
                            JOIN roles r ON u.rol = r.id
                            WHERE u.email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['name'];
        $_SESSION['usuario_rol'] = $usuario['rol_nombre'];

        // Redirige según el rol
        if ($usuario['rol_nombre'] === 'admin') {
            header('Location: ../pages/home.php'); // o panel de admin
        } else {
            header('Location: ../pages/home.php');
        }
        exit();
    } else {
        echo "Correo o contraseña incorrectos.";
    }
} else {
    echo "Debes llenar todos los campos.";
}
?>

