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
        throw new Exception("Parámetro 'codigo' no proporcionado.");
    }

    $codeworker = $_GET['codeworker'];
    $dateinit = $_GET['dateinit'] ?? null;
    $dateend = $_GET['dateend'] ?? null;
    $anio = $_GET['anio'] ?? null;
    $mes = $_GET['mes'] ?? null;

    $sql = "SELECT 
        DATE(ti.tickdate) AS tickdate,
        IFNULL(TIME(ti.tickdate), '00:00:00') AS ticktime_in,
        IFNULL(TIME(ts.tickdate), '00:00:00') AS ticktime_out
    FROM 
        tick ti
    LEFT JOIN 
        tick ts ON ti.tickworkercode = ts.tickworkercode 
        AND ts.tickstate = 'S'
        AND ts.tickdate > ti.tickdate
        AND ts.tickdate <= DATE_ADD(ti.tickdate, INTERVAL 1 DAY)
    WHERE 
        ti.tickworkercode = :codeworker
        AND ti.tickstate = 'I'
        AND ti.tickdelete = 0
        AND ts.tickdelete = 0";

    if ($dateinit && $dateend) {
        $sql .= " AND DATE(ti.tickdate) BETWEEN :dateinit AND :dateend";
    } elseif ($anio && $mes) {
        $sql .= " AND YEAR(ti.tickdate) = :anio AND MONTH(ti.tickdate) = :mes";
    } else {
        $sql .= " ORDER BY ti.tickdate DESC LIMIT 10";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codeworker', $codeworker);

    if ($dateinit && $dateend) {
        $stmt->bindParam(':dateinit', $dateinit);
        $stmt->bindParam(':dateend', $dateend);
    } elseif ($anio && $mes) {
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':mes', $mes);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $processedEntries = [];
    $processedExits = [];
    $finalData = [];

    /*foreach ($result as $row) {
        $tickdate = $row['tickdate'];
        $ticktime_in = $row['ticktime_in'];
        $ticktime_out = $row['ticktime_out'];

        if (in_array($ticktime_in, $processedEntries)) {
            continue;
        }

        if (in_array($ticktime_out, $processedExits)) {
            continue;
        }

        $processedEntries[] = $ticktime_in;
        $processedExits[] = $ticktime_out;

        $finalData[] = [
            'tickdate' => $tickdate,
            'ticktime_in' => $ticktime_in,
            'ticktime_out' => $ticktime_out
        ];
    }*/

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