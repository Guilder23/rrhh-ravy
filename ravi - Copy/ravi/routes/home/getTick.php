<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

include '../../config/database.php';

try {
    if (!isset($_GET['fecha'])) {
        throw new Exception('Fecha no proporcionada');
    }

    $fechaSeleccionada = $_GET['fecha'];

    $db = new Database('local');
    $conn = $db->getConnection();
    
    $sql = "SELECT 
                CONCAT(w.workername1, ' ', IFNULL(w.workername2, ''), ' ', w.workerlastname1, ' ', IFNULL(w.workerlastname2, '')) AS fullname, 
                TIME(t.tickdate) AS hora, 
                DATE(t.tickdate) AS fecha, 
                t.tickstate, 
                w.workerimg
            FROM tick t
            JOIN worker w ON w.workercode = t.tickworkercode
            WHERE t.tickdelete = 0 AND DATE(t.tickdate) = :fechaSeleccionada
            ORDER BY t.tickdate";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fechaSeleccionada', $fechaSeleccionada, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $result
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>