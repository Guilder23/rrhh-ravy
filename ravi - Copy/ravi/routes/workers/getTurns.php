<?php
require_once '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$sql = "SELECT 
            codeturn AS id, 
            turnname AS turn_name, 
            TIME_FORMAT(turnstart, '%H:%i') AS turn_start, 
            TIME_FORMAT(turnend, '%H:%i') AS turn_end 
        FROM turn 
        WHERE turndelete = 0";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute();
    $turns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($turns);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al cargar turnos: ' . $e->getMessage()]);
}
?>