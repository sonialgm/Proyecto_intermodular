<?php
session_start();

// Verificar que el administrador esté autenticado
if (!isset($_SESSION['admin_id'])) {
    // Si no está autenticado, redirigir al login
    header("Location: login_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    echo "<h2>Bienvenid@ administrador " . htmlspecialchars($_SESSION['admin_username']) . "</h2>";
    ?>
    
    <p><a href="logout_admin.php">Cerrar sesión</a></p>
</body>
</html>

