<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Type: application/json");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $sqlBonos = "SELECT 
                    b.codebond,
                    b.bondcode,
                    b.bondreason,
                    b.bondvalue
                 FROM bond b
                 WHERE b.bonddelete = 0
                 ORDER BY b.bondcode ASC";
    
    $stmtBonos = $conn->prepare($sqlBonos);
    $stmtBonos->execute();
    $bonos = $stmtBonos->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'bondw' => $bonos
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}