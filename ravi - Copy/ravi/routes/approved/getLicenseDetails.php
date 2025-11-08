<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    // Obtener parámetros de la URL
    $workercode = $_GET['workercode'] ?? '';
    $codelicense = $_GET['codelicense'] ?? '';
    
    if(empty($workercode) || empty($codelicense)) {
        throw new Exception("Parámetros incompletos");
    }

    $sql = "SELECT 
                CONCAT(
                    IFNULL(w.workername1, ''),
                    IF(w.workername2 IS NOT NULL, CONCAT(' ', w.workername2), ''),
                    IF(w.workerlastname1 IS NOT NULL, CONCAT(' ', w.workerlastname1), ''),
                    IF(w.workerlastname2 IS NOT NULL, CONCAT(' ', w.workerlastname2), '')
                ) AS fullname, 
                w.workercode,
                w.workersection,
                w.workerrol,
                w.workerarea,
                li.licensereason,
                li.licenseinit,
                li.licenseend,
                li.licensecreate,
                tl.tlicenseapproved,
                tl.approval_status,
                tl.tlicensename as observacion,
                CASE 
                    WHEN TIMESTAMPDIFF(HOUR, li.licenseinit, li.licenseend) < 24 THEN 'hora'
                    ELSE 'fechas'
                END AS tipo
            FROM worker w
            JOIN license li ON li.codeworker = w.codeworker
            JOIN tlicense tl ON tl.codetlicense = li.licensecode
            WHERE w.workercode = :workercode AND li.codelicense = :codelicense AND tl.approval_status = '1'";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':workercode', $workercode);
    $stmt->bindParam(':codelicense', $codelicense);
    $stmt->execute();

    $license = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'license' => $license,
        'tipo' => $license['tipo']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}