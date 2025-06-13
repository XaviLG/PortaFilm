<?php
session_start();
include '../config/db.php';

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {
    $qs = http_build_query(['error' => 'Debes llenar todos los campos.']);
    header("Location: ../pages/login.php?$qs");
    exit;
}

$stmt = $conn->prepare("SELECT u.id, u.name, u.password, u.rol, r.name AS rol_nombre
                        FROM `user` u
                        JOIN roles r ON u.rol = r.id
                        WHERE u.email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || !password_verify($password, $usuario['password'])) {
    // credenciales invalidas
    $qs = http_build_query(['error' => 'Correo o contraseña incorrectos.']);
    header("Location: ../pages/login.php?$qs");
    exit;
}

// exito: guardamos sesion
$_SESSION['usuario_id']     = $usuario['id'];
$_SESSION['usuario_nombre'] = $usuario['name'];
$_SESSION['usuario_rol']    = $usuario['rol_nombre'];

header('Location: ../pages/home.php');
exit;
