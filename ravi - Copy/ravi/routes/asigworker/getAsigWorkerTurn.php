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
                 FROM turnw tw
                 JOIN worker w ON tw.codeworker = w.codeworker
                 JOIN turn t ON tw.codeturn = t.codeturn
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

    $sqlTurnos = "
        SELECT 
            tw.codeturnw,
            tw.turnwcreate,
            w.workercode, 
            CONCAT(
                COALESCE(w.workername1, ''), ' ', 
                COALESCE(w.workername2, ''), ' ', 
                COALESCE(w.workerlastname1, ''), ' ', 
                COALESCE(w.workerlastname2, '')
            ) AS fullname, 
            CONCAT (
                COALESCE(tw.turnwname, ''), ' ', 
                COALESCE(tw.turnwlastname, '')
            ) AS asigfullname,
            t.turnname, 
            t.turnstart, 
            t.turnend,
            tw.turnwdelete
        FROM turnw tw
        JOIN worker w ON tw.codeworker = w.codeworker
        JOIN turn t ON tw.codeturn = t.codeturn
        WHERE (w.workercode LIKE :buscar OR 
               CONCAT(
                   COALESCE(w.workername1, ''), ' ', 
                   COALESCE(w.workername2, ''), ' ', 
                   COALESCE(w.workerlastname1, ''), ' ', 
                   COALESCE(w.workerlastname2, '')
               ) LIKE :buscar)
        ORDER BY tw.codeturnw DESC
        LIMIT :inicio, :limite
    ";
    $stmtTurnos = $conn->prepare($sqlTurnos);
    $stmtTurnos->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTurnos->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtTurnos->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtTurnos->execute();
    $turnos = $stmtTurnos->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($turnos as $row) {
        $data[] = [
            'codeturnw' => $row['codeturnw'],
            'turnwcreate' => $row['turnwcreate'],
            'workercode' => $row['workercode'],
            'fullname' => $row['fullname'],
            'asigfullname' => $row['asigfullname'],
            'turnname' => $row['turnname'],
            'turnstart' => $row['turnstart'],
            'turnend' => $row['turnend'],
            'turnwdelete' => $row['turnwdelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'turnos' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}