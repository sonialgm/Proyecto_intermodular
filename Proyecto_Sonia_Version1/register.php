<?php
// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');

    if ($password === '' || $password_confirm === '') {
        $message = "Debes introducir la contraseña en ambos campos.";
    } elseif ($password !== $password_confirm) {
        $message = "Las contraseñas no coinciden.";
    } else {
        try {

            // Generar código de conversación
            // Obtener tiempo en milisegundos
            $timestamp = microtime(true);
            $timestamp = (int)($timestamp * 1000);

            // Caracteres permitidos para el código (A-Z y 0-9)
            $caracteres = array_merge(range('A', 'Z'), range('0', '9'));

            // Función que convierte el timestamp a un código personalizado
            function generarCodigo($timestamp, $caracteres){
                $codigo = "";
                $tamanyoArray = count($caracteres);

                // Convertir a base del tamaño del array
                while ($timestamp > 0) {
                    $resto = $timestamp % $tamanyoArray;
                    $codigo .= $caracteres[$resto];
                    $timestamp = floor($timestamp / $tamanyoArray);
                }
                return strrev($codigo); // se invierte para obtener código final
            }

            // Generar código
            $codigo = generarCodigo($timestamp, $caracteres);

            // Hashear contraseña
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO login (username, password) VALUES (:username, :password)");
            $stmt->execute([
                'username' => $codigo,
                'password' => $hash
            ]);

            $message = "Conversación creada. Tu código es: <b>$codigo</b><br>¡Guárdalo para acceder!";

        } catch (\PDOException $e) {
            $message = "Error en la BD: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear conversación</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Crear nueva conversación</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <form action="" method="POST">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirm">Repite la contraseña:</label>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>

        <button type="submit">Crear conversación</button>
    </form>

    <p>¿Ya tienes una conversación? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>

