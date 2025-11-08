<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $sql = "SELECT codebond, bondreason, bondvalue FROM turn WHERE bondelete = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bonos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($bonos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
