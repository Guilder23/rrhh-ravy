<?php
require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$sql = "SELECT codesection, namesection FROM section WHERE sectiondelete = 0";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($sections);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al cargar secciones: ' . $e->getMessage()]);
}
?>