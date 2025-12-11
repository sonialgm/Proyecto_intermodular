<?php
require 'db.php'; // Conexión a la base de datos

// Array con los usuarios y sus contraseñas
$users = [
    'admin1' => 'password1',
    'admin2' => 'password2',
    'admin3' => 'password3'
];

// Preparar la consulta SQL
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (:username, :password)");

foreach ($users as $username => $password) {
    // Generar el hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Ejecutar la consulta con el nombre de usuario y la contraseña hasheada
    $stmt->execute([
        'username' => $username,
        'password' => $hashed_password
    ]);

    echo "Usuario $username insertado correctamente con la contraseña hasheada.<br>";
}
?>

