<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

    $sql = "SELECT 
                tl.codetlicense,
                li.codelicense,
                li.licensecreate, 
                CONCAT_WS(' ', 
                    w.workername1, 
                    w.workername2, 
                    w.workerlastname1, 
                    w.workerlastname2
                ) AS fullname, 
                w.workercode, 
                w.workerrol, 
                w.workerarea
            FROM 
                tlicense tl
            JOIN 
                license li ON li.codelicense = tl.tlicensecode
            JOIN 
                worker w ON w.codeworker = li.codeworker
            WHERE 
                tl.approval_status = 0;
            AND (w.workercode LIKE :buscar OR w.workerlastname1 LIKE :buscar)
            ORDER by li.licensecreate DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['buscar' => "%$buscar%"]);

    $licenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['licenses' => $licenses]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
