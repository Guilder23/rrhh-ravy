<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

include '../../config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($_GET['codeworker'])) {
        throw new Exception("Parámetro 'codeworker' no proporcionado.");
    }

    $codeworker = $_GET['codeworker'];
    $fecha = $_GET['fecha'];

    $query = "
        SELECT *
        FROM license
        WHERE codeworker = (
            SELECT codeworker
            FROM worker
            WHERE workercode = :codeworker
        ) AND :fecha BETWEEN DATE(licenseinit) AND DATE(licenseend)
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codeworker', $codeworker);
    $stmt->bindParam(':fecha', $fecha);

    $stmt->execute();

    $license = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($fechaInicio === $fechaFin && $horaInicio !== $horaFin) {
                    $tipo = 'hora';
                } else {
                    $tipo = 'fechas';
                }

    if ($license) {
        echo json_encode([
            'success' => true,
            'license' => $license,
            'tipo' => $tipo
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró ninguna licencia para esta fecha.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>