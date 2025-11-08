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
                 FROM bondw bw
                 JOIN worker w ON bw.codeworker = w.codeworker
                 JOIN bond b ON bw.codebond = b.codebond
                 WHERE (w.workercode LIKE :buscar OR 
                        CONCAT(
                            COALESCE(w.workername1, ''), ' ', 
                            COALESCE(w.workername2, ''), ' ', 
                            COALESCE(w.workerlastname1, ''), ' ', 
                            COALESCE(w.workerlastname2, '')
                        ) LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalRegistros / $limite);

    $sqlBondw = "
        SELECT 
            bw.codebondw,
            bw.bondwcreate,
            w.workercode, 
            CONCAT(
                COALESCE(w.workername1, ''), ' ', 
                COALESCE(w.workername2, ''), ' ', 
                COALESCE(w.workerlastname1, ''), ' ', 
                COALESCE(w.workerlastname2, '')
            ) AS fullname, 
            CONCAT (
                COALESCE(bw.bondwname, ''), ' ', 
                COALESCE(bw.bondwlastname, '')
            ) AS asigfullname,
            b.bondname, 
            b.bondstart, 
            b.bondend,
            bw.bondwdelete
        FROM bondw bw
        JOIN worker w ON bw.codeworker = w.codeworker
        JOIN bond b ON bw.codebond = b.codebond
        WHERE (w.workercode LIKE :buscar OR 
               CONCAT(
                   COALESCE(w.workername1, ''), ' ', 
                   COALESCE(w.workername2, ''), ' ', 
                   COALESCE(w.workerlastname1, ''), ' ', 
                   COALESCE(w.workerlastname2, '')
               ) LIKE :buscar)
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
            'codebondw' => $row['codebondw'],
            'bondwcreate' => $row['bondwcreate'],
            'workercode' => $row['workercode'],
            'fullname' => $row['fullname'],
            'asigfullname' => $row['asigfullname'],
            'bondname' => $row['bondname'],
            'bondstart' => $row['bondstart'],
            'bondend' => $row['bondend'],
            'bondwdelete' => $row['bondwdelete']
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