<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $sql = "SELECT codearea, areaname FROM area WHERE areadelete = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($areas);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
