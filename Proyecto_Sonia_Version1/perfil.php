<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['user_id'])) {
    echo "No has iniciado sesión.";
    exit;
}

$codigo = htmlspecialchars($_SESSION['codigo']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu conversación</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Bienvenid@ a tu conversación: <?php echo $codigo; ?></h2>

    <p><a href="register.php">Crear nueva conversación</a></p>

    <p><a href="logout.php">Cerrar sesión / Cambiar conversación</a></p>
</body>
</html>
