<?php
require_once '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$sql = "SELECT codearea, areaname FROM area WHERE areadelete = 0";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute();
    $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($areas);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al cargar áreas: ' . $e->getMessage()]);
}
?>