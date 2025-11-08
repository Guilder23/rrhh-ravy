<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
        $sql = "SELECT codeworker, workercode, CONCAT(
            COALESCE(workername1, ''), ' ', 
            COALESCE(workername2, ''), ' ', 
            COALESCE(workerlastname1, ''), ' ', 
            COALESCE(workerlastname2, '')
        ) AS fullname 
        FROM worker
        ORDER BY workercode";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($trabajadores);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}