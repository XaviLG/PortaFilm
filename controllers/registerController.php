<?php
session_start();
include '../config/db.php';

// Recogemos y saneamos
$name     = trim($_POST['name']     ?? '');
$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');
$rol      = 2; // usuario

if (!$name || !$email || !$password) {
    // Si falta algún campo, volvemos al formulario de registro con mensaje
    $qs = http_build_query(['error' => 'Todos los campos son obligatorios.']);
    header("Location: ../pages/register.php?$qs");
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO user (name, email, password, rol) VALUES (?, ?, ?, ?)");
try {
    $stmt->execute([$name, $email, $password_hash, $rol]);
    // Al insertar correctamente, redirigimos directamente al login.php
    header('Location: ../pages/login.php?registered=1');
    exit;
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        // correo duplicado
        $qs = http_build_query(['error' => 'El correo ya está registrado.']);
        header("Location: ../pages/register.php?$qs");
        exit;
    } else {
        // otro error
        $qs = http_build_query(['error' => 'Error interno. Inténtalo más tarde.']);
        header("Location: ../pages/register.php?$qs");
        exit;
    }
}


