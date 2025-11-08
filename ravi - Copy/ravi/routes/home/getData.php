<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

include '../../config/database.php';

try {
    $db = new Database('local');
    $conn = $db->getConnection();

    if (isset($_GET['fecha'])) {
        $fechaSeleccionada = $_GET['fecha'];
    } else {
        $sqlUltimaFecha = "SELECT DATE(MAX(tickdate)) AS ultima_fecha FROM tick";
        $stmtUltimaFecha = $conn->prepare($sqlUltimaFecha);
        $stmtUltimaFecha->execute();
        $resultUltimaFecha = $stmtUltimaFecha->fetch(PDO::FETCH_ASSOC);

        if ($resultUltimaFecha && isset($resultUltimaFecha['ultima_fecha'])) {
            $fechaSeleccionada = $resultUltimaFecha['ultima_fecha'];
        } else {
            throw new Exception('No se pudo obtener la fecha del último registro');
        }
    }

    // Consulta SQL que utiliza la fecha recibida
    $sql = "WITH RankedTicks AS (
                SELECT 
                    DATE(ti.tickdate) AS Fecha,
                    TIME(ti.tickdate) AS Hora,
                    ti.tickworkercode AS CodigoTrabajador,
                    ti.tickstate AS Estado,
                    w.workersex AS SexoTrabajador,
                    ROW_NUMBER() OVER (
                        PARTITION BY ti.tickworkercode 
                        ORDER BY ti.tickdate DESC, TIME(ti.tickdate) DESC
                    ) AS RowNum
                FROM 
                    tick ti
                JOIN 
                    worker w ON w.workercode = ti.tickworkercode
                WHERE 
                    ti.tickstate = 'I'
                    AND DATE(ti.tickdate) = :fechaSeleccionada 
            )
            SELECT 
                Fecha, Hora, CodigoTrabajador, Estado, SexoTrabajador
            FROM 
                RankedTicks
            WHERE 
                RowNum = 1
            ORDER BY 
                CodigoTrabajador ASC;
            ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':fechaSeleccionada', $fechaSeleccionada, PDO::PARAM_STR);

    $stmt->execute(); 

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $result
    ]);
} catch (Exception $e) {
    // Manejar errores y devolver un mensaje de error en formato JSON
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 