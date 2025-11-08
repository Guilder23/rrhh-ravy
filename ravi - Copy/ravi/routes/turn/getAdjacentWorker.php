<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

include '../../config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($_GET['codeworker']) || !isset($_GET['direction'])) {
        throw new Exception("Parámetros requeridos no proporcionados.");
    }

    $codeworker = $_GET['codeworker'];
    $direction = (int)$_GET['direction'];

    $sqlCurrent = "SELECT w.codeworker, w.workercode, 
                  CONCAT(
                      COALESCE(w.workername1, ''), ' ', 
                      COALESCE(w.workername2, ''), ' ', 
                      COALESCE(w.workerlastname1, ''), ' ', 
                      COALESCE(w.workerlastname2, '')
                  ) AS fullname,
                  w.workerorder
                  FROM worker w
                  WHERE w.codeworker = ?";
    
    $stmtCurrent = $conn->prepare($sqlCurrent);
    $stmtCurrent->execute([$codeworker]);
    $currentWorker = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

    if (!$currentWorker) {
        throw new Exception("Trabajador actual no encontrado.");
    }

    // Buscamos el trabajador siguiente o anterior
    $sqlAdjacent = "SELECT w.codeworker, w.workercode, 
                   CONCAT(
                       COALESCE(w.workername1, ''), ' ', 
                       COALESCE(w.workername2, ''), ' ', 
                       COALESCE(w.workerlastname1, ''), ' ', 
                       COALESCE(w.workerlastname2, '')
                   ) AS fullname
                   FROM worker w
                   WHERE w.workerorder " . ($direction > 0 ? ">" : "<") . " ?
                   ORDER BY w.workerorder " . ($direction > 0 ? "ASC" : "DESC") . "
                   LIMIT 1";

    $stmtAdjacent = $conn->prepare($sqlAdjacent);
    $stmtAdjacent->execute([$currentWorker['workerorder']]);
    $adjacentWorker = $stmtAdjacent->fetch(PDO::FETCH_ASSOC);

    if ($adjacentWorker) {
        echo json_encode([
            'success' => true,
            'worker' => $adjacentWorker
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No hay más trabajadores en esa dirección'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>