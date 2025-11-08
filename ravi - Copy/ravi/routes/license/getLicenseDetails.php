<?php
session_start();
require '../../config/database.php';

if (isset($_GET['id'])) {
    $licenseId = $_GET['id'];

    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        try {
            $sql = "SELECT l.*, 
                           CONCAT(w.workername1, ' ', w.workername2, ' ', w.workerlastname1, ' ', w.workerlastname2) AS fullname, 
                           w.workercode 
                    FROM license l
                    JOIN worker w ON l.codeworker = w.codeworker
                    WHERE l.codelicense = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $licenseId);
            $stmt->execute();

            $license = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($license) {
                $fechaInicio = date('Y-m-d', strtotime($license['licenseinit']));
                $horaInicio = date('H:i:s', strtotime($license['licenseinit']));

                $fechaFin = date('Y-m-d', strtotime($license['licenseend']));
                $horaFin = date('H:i:s', strtotime($license['licenseend']));

                if ($fechaInicio === $fechaFin && $horaInicio !== $horaFin) {
                    $tipo = 'hora';
                } else {
                    $tipo = 'fechas';
                }

                echo json_encode([
                    'success' => true,
                    'license' => $license,
                    'tipo' => $tipo
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Licencia no encontrada'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error en la consulta: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al conectar con la base de datos'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID de licencia no proporcionado'
    ]);
}