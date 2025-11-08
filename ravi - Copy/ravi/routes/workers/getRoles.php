<?php
require_once '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$sql = "SELECT codeoccupation, nameoccupation FROM occupation WHERE occupationdelete = 0";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($roles);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al cargar roles: ' . $e->getMessage()]);
}
?>