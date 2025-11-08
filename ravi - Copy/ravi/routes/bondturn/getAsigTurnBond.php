<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$inicio = ($pagina > 1) ? ($pagina * $limite) - $limite : 0;

try {
    $sqlTotal = "SELECT COUNT(*) as total 
                 FROM bondt bt
                 JOIN turn t ON bt.codeturn = t.codeturn
                 JOIN bond b ON bt.codebond = b.codebond
                 WHERE (t.turnname LIKE :buscar OR 
                        b.bondcode LIKE :buscar OR
                        b.bondreason LIKE :buscar OR
                        CONCAT(
                            COALESCE(bt.bondtname, ''), ' ', 
                            COALESCE(bt.bondtlastname, '')
                        ) LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalRegistros / $limite);

    $sqlBondt = "
        SELECT 
            bt.codebondt,
            bt.bondtcreate,
            t.turnname, 
            t.turnstart,
            t.turnend,
            CONCAT(
                COALESCE(bt.bondtname, ''), ' ', 
                COALESCE(bt.bondtlastname, '')
            ) AS fullname, 
            b.codebond,
            b.bondcode,
            b.bondreason,
            b.bondvalue,
            b.bondnro,
            b.bondfee,
            DATE(b.bondcreate) AS fecha,
            b.bondelete,
            bt.bondtdelete
        FROM bondt bt
        JOIN turn t ON bt.codeturn = t.codeturn
        JOIN bond b ON bt.codebond = b.codebond
        WHERE (t.turnname LIKE :buscar OR 
               b.bondcode LIKE :buscar OR
               b.bondreason LIKE :buscar OR
               CONCAT(
                   COALESCE(bt.bondtname, ''), ' ', 
                   COALESCE(bt.bondtlastname, '')
               ) LIKE :buscar)
        ORDER BY bt.codebondt DESC
        LIMIT :inicio, :limite
    ";
    $stmtBondt = $conn->prepare($sqlBondt);
    $stmtBondt->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtBondt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtBondt->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtBondt->execute();
    $bondts = $stmtBondt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($bondts as $row) {
        $data[] = [
            'codebondt' => $row['codebondt'],
            'bondtcreate' => $row['bondtcreate'],
            'turnname' => $row['turnname'],
            'turnstart' => $row['turnstart'],
            'turnend' => $row['turnend'],
            'fullname' => $row['fullname'],
            'codebond' => $row['codebond'],
            'bondcode' => $row['bondcode'],
            'bondname' => $row['bondname'],
            'bondreason' => $row['bondreason'],
            'bondvalue' => $row['bondvalue'],
            'bondnro' => $row['bondnro'],
            'bondfee' => $row['bondfee'],
            'bondstart' => $row['bondstart'],
            'bondend' => $row['bondend'],
            'fecha' => $row['fecha'],
            'bondelete' => $row['bondelete'],
            'bondtdelete' => $row['bondtdelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'bondts' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}