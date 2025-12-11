<?php
session_start();
require 'db.php'; // Conexión a la base de datos

$message = ''; // Mensaje de error si la autenticación falla

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $message = "Completa todos los campos.";
    } else {
        try {
            // Buscar el usuario en la base de datos
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch(); // Obtener los datos del administrador

            // Verificar la contraseña con password_verify
            if ($admin && password_verify($password, $admin['password'])) {
                // Si las credenciales son correctas, guardamos los datos en la sesión
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header("Location: perfil_admin.php"); // Redirigir al perfil
                exit;
            } else {
                $message = "Usuario o contraseña incorrectos.";
            }

        } catch (\PDOException $e) {
            $message = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login Administrador</h2>

    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulario de Login -->
    <form action="" method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
        
         <p>¿Volver a la página principal? <a href="index.php">Haz clic aquí</a></p>
    </form>
</body>
</html>

