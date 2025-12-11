<?php
// Inicio de sesión y conexión BD
session_start(); 
require 'db.php';

$message = '';

// Comprobar si el fomrulario se envió por POST y obtener valores
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $codigo = trim($_POST['codigo'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validación de campos (verificar campos vacíos)
    if ($codigo === '' || $password === '') {
        $message = "Completa todos los campos.";
    } else {
        try {
            // Búsqueda en BD
            $stmt = $pdo->prepare("SELECT * FROM login WHERE username = :codigo LIMIT 1"); // consulta preparada
            $stmt->execute(['codigo' => $codigo]); // ejecuta consulta
            $user = $stmt->fetch(); // obtiene usuario (array asociativo)

            // Verificar contraseña (si existe y es correcta)
            if ($user && password_verify($password, $user['password'])) {
                // si coincide guarda datos en la sesión y redirige al perfil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['codigo'] = $user['username'];

                header("Location: perfil.php");
                exit;
                
            } else { // si el usuario no existe o contraseña incorrecta
                $message = "Código o contraseña incorrectos.";
            }

        } catch (\PDOException $e) { // error en BD
            $message = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de Conversación</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Accede a tu conversación</h2>

    <?php if ($message !== ''): ?>
        <!-- Muestra los errores o mensajes -->
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulario de login -->
    <form action="" method="POST">
        <label for="codigo">Código de conversación:</label>
        <input type="text" id="codigo" name="codigo" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
<p>Crea una conversación nueva <a href="register.php">aquí</a></p>

 <p>¿Volver a la página principal? <a href="index.php">Haz clic aquí</a></p>
</body>
</html>
