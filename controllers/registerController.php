<?php
include '../config/db.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$rol = 2; // Asignación fija para "usuario"

if ($name && $email && $password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (name, email, password, rol) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $password_hash, $rol]);
        echo "Registro exitoso. <a href='../pages/login.php'>Inicia sesión</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "El correo ya está registrado.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Todos los campos son obligatorios.";
}
?>

