<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new \InvalidArgumentException(sprintf('%s no existe', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

$envPath = __DIR__ . '/.env';

loadEnv($envPath);

class Database {
    private $host;
    private $db_name;
    private $db_name1;
    private $username;            
    private $password;                  
    public $conn;

    public function __construct($environment = 'production') {
        $this->switchConnection($environment);
    }

    private function switchConnection($environment) {
        if ($environment === 'local') {
            $this->host = getenv('DB_HOST_LOCAL');
            $this->db_name = getenv('DB_NAME_LOCAL');
            $this->db_name1 = getenv('DB_NAME1_LOCAL');
            $this->username = getenv('DB_USERNAME_LOCAL');
            $this->password = getenv('DB_PASSWORD_LOCAL');
        } else {
            $this->host = getenv('DB_HOST');
            $this->db_name = getenv('DB_NAME');
            $this->db_name1 = getenv('DB_NAME1');
            $this->username = getenv('DB_USERNAME');
            $this->password = getenv('DB_PASSWORD');
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            echo "Error de conexion: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
