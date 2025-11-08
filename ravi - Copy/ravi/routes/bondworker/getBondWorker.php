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
    $sqlTotal = "
        SELECT COUNT(*) as total 
        FROM bondw bw
        JOIN worker w ON bw.codeworker = w.codeworker
        JOIN bond b ON bw.codebond = b.codebond
        WHERE (w.workercode LIKE :buscar OR 
               CONCAT(w.workername1, ' ', w.workername2, ' ', w.workerlastname1, ' ', w.workerlastname2) LIKE :buscar OR
               b.bondcode LIKE :buscar OR b.bondreason LIKE :buscar)
    ";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalRegistros / $limite);

    $sqlBondw = "
        SELECT 
            bw.codebondw,
            bw.codeworker,
            bw.codebond,
            bw.bondwname,
            bw.bondwlastname,
            bw.bondwcreate,
            bw.bondwdelete,
            w.workercode,
            CONCAT(w.workername1, ' ', IFNULL(w.workername2, ''), ' ', w.workerlastname1, ' ', IFNULL(w.workerlastname2, '')) AS fullname,
            b.bondcode,
            b.bondreason,
            b.bondvalue,
            b.bondnro,
            b.bondfee
        FROM bondw bw
        JOIN worker w ON bw.codeworker = w.codeworker
        JOIN bond b ON bw.codebond = b.codebond
        WHERE (w.workercode LIKE :buscar OR 
               CONCAT(w.workername1, ' ', w.workername2, ' ', w.workerlastname1, ' ', w.workerlastname2) LIKE :buscar OR
               b.bondcode LIKE :buscar OR b.bondreason LIKE :buscar)
        ORDER BY bw.codebondw DESC
        LIMIT :inicio, :limite
    ";
    $stmtBondw = $conn->prepare($sqlBondw);
    $stmtBondw->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtBondw->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtBondw->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtBondw->execute();
    $bondws = $stmtBondw->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($bondws as $row) {
        $data[] = [
            'codebondw' => (int) $row['codebondw'],
            'codeworker' => (int) $row['codeworker'],
            'codebond' => (int) $row['codebond'],
            'bondwname' => $row['bondwname'],
            'bondwlastname' => $row['bondwlastname'],
            'bondwcreate' => $row['bondwcreate'],
            'bondwdelete' => (int) $row['bondwdelete'],
            'workercode' => $row['workercode'],
            'fullname' => $row['fullname'],
            'bondcode' => $row['bondcode'],
            'bondreason' => $row['bondreason'],
            'bondvalue' => (float) $row['bondvalue'],
            'bondnro' => $row['bondnro'],
            'bondfee' => (float) $row['bondfee']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'bondws' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}