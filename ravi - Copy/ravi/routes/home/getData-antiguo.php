<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

include '../../config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

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
                    AND DATE(ti.tickdate) = (
                        SELECT MAX(DATE(tickdate)) 
                        FROM tick 
                        WHERE tickstate = 'I'
                    )
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
