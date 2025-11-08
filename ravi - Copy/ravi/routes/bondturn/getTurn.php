<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $sql = "SELECT 
                t.codeturn, 
                t.turnname,  
                TIME_FORMAT(t.turnstart, '%H:%i') as turnstart,
                TIME_FORMAT(t.turnend, '%H:%i') as turnend
            FROM turn t
            WHERE t.turndelete = 0
            ORDER BY t.codeturn ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $turnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $turnos
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}