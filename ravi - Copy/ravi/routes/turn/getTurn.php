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
    $sqlTotal = "SELECT COUNT(*) as total FROM turn 
                 WHERE (codeturn LIKE :buscar OR turnname LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalTurnos = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalTurnos / $limite);

    // Consulta para obtener los registros paginados
    $sqlTurnos = "
        SELECT 
            codeturn, 
            turnname, 
            turnstart, 
            turnend,
            turncreate,
            turndelete
        FROM turn
        WHERE (turnname LIKE :buscar)
        ORDER BY codeturn ASC
        LIMIT :inicio, :limite;
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
            'codeturn' => $row['codeturn'],
            'turnname' => $row['turnname'],
            'turnstart' => $row['turnstart'],
            'turnend' => $row['turnend'],
            'turncreate' => $row['turncreate'],
            'turndelete' => (int) $row['turndelete']
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