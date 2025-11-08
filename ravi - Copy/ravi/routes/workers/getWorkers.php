<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$inicio = ($pagina > 1) ? ($pagina * $limite) - $limite : 0;

try {
    // Consulta para obtener el total de trabajadores (sin filtrar por nameoccupation)
    $sqlTotal = "
        SELECT COUNT(*) as total 
        FROM worker
        LEFT JOIN occupation ON occupation.codeoccupation = worker.workerrol
        WHERE (workercode LIKE :buscar 
        OR CONCAT(workername1, ' ', workername2, ' ', workerlastname1, ' ', workerlastname2) LIKE :buscar)
    ";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalWorkers = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalWorkers / $limite);

    // Consulta para obtener los trabajadores (sin filtrar por nameoccupation)
    $sqlWorkers = "
        SELECT 
            codeworker, 
            workercode, 
            CONCAT(
                COALESCE(workername1, ''), ' ', 
                COALESCE(workername2, ''), ' ', 
                COALESCE(workerlastname1, ''), ' ', 
                COALESCE(workerlastname2, '')
            ) as fullname,
            workerdocnumber, 
            workerimg, 
            COALESCE(occupation.nameoccupation, '') as workerrol, 
            workerdateinit, 
            workersex
        FROM worker
        LEFT JOIN occupation ON occupation.codeoccupation = worker.workerrol
        WHERE (workercode LIKE :buscar 
        OR CONCAT(workername1, ' ', workername2, ' ', workerlastname1, ' ', workerlastname2) LIKE :buscar)
        ORDER BY codeworker DESC
        LIMIT :inicio, :limite
    ";
    $stmtWorkers = $conn->prepare($sqlWorkers);
    $stmtWorkers->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtWorkers->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtWorkers->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtWorkers->execute();
    $workers = $stmtWorkers->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($workers as $row) {
        $data[] = [
            'codeworker' => $row['codeworker'],
            'workercode' => $row['workercode'],
            'fullname' => $row['fullname'],
            'workerdocnumber' => $row['workerdocnumber'],
            'workerimg' => !empty($row['workerimg']) ? $row['workerimg'] : '/resourse/images/default_imageM.webp',
            'workerrol' => $row['workerrol'],
            'workerdateinit' => $row['workerdateinit'],
            'workersex' => $row['workersex']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'workers' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}