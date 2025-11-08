<?php
require_once 'config/database.php';

try {
    echo "Intentando conexión en modo local...\n";
    $database = new Database('local');
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "¡Conexión exitosa a la base de datos!\n";
        echo "Usuario: " . getenv('DB_USERNAME_LOCAL') . "\n";
        echo "Base de datos: " . getenv('DB_NAME_LOCAL') . "\n";
    }
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
    echo "Configuración actual:\n";
    echo "Host: " . getenv('DB_HOST_LOCAL') . "\n";
    echo "Base de datos: " . getenv('DB_NAME_LOCAL') . "\n";
    echo "Usuario: " . getenv('DB_USERNAME_LOCAL') . "\n";
    echo "Contraseña está " . (getenv('DB_PASSWORD_LOCAL') ? "configurada" : "vacía") . "\n";
}
?>
