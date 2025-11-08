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
                b.codebond, 
                b.bondcode,  
                b.bondreason, 
                b.bondvalue
            FROM bond b
            WHERE b.bondelete = 0
            ORDER BY b.codebond ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bonos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $bonos
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}