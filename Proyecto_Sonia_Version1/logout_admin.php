<?php
// Iniciar sesión
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión completamente
session_destroy();

// Redirigir al login de administrador
header("Location: login_admin.php");
exit;
?>

