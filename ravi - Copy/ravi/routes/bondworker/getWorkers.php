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
                w.codeworker,
                w.workercode,
                CONCAT(
                    IFNULL(w.workername1, ''),
                    IF(w.workername2 IS NOT NULL, CONCAT(' ', w.workername2), ''),
                    IF(w.workerlastname1 IS NOT NULL, CONCAT(' ', w.workerlastname1), ''),
                    IF(w.workerlastname2 IS NOT NULL, CONCAT(' ', w.workerlastname2), '')
                ) AS fullname
            FROM worker w
            WHERE w.workerstate = 1
            ORDER BY w.workercode ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'workers' => $workers
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}