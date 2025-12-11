<?php
// Datos para conectar con la BD:
$host = 'localhost'; // servidor donde está MySQL
$db   = 'proyecto3'; // nombre BD
$user = 'root'; // usuario de MySQL (por defecto en XAMPP)
$pass = ''; // contraseña (vacía por defecto)
$charset = 'utf8mb4'; // codificación

// Construir el DNS:
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // actica errores tipo excepción
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // obtiene resultados como array asociativos
    PDO::ATTR_EMULATE_PREPARES => false, // usa sentencias preparadas para mayor seguridad
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // intentamos crear la conexión usando PDO
} catch (\PDOException $e) { // si falla
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}
?>
