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
    // Consulta para obtener el total de registros
    $sqlTotal = "SELECT COUNT(*) as total FROM bond 
                 WHERE (bondcode LIKE :buscar OR bondreason LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalBonds = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalBonds / $limite);

    // Consulta para obtener los registros paginados
    $sqlBonds = "
        SELECT 
            codebond, 
            bondcode, 
            bondreason, 
            bondvalue, 
            bondnro, 
            bondfee, 
            DATE(bondcreate) AS fecha, 
            bondelete
        FROM bond
        WHERE (bondcode LIKE :buscar OR bondreason LIKE :buscar)
        ORDER BY fecha DESC
        LIMIT :inicio, :limite
    ";
    $stmtBonds = $conn->prepare($sqlBonds);
    $stmtBonds->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtBonds->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtBonds->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtBonds->execute();
    $bonds = $stmtBonds->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($bonds as $row) {
        $data[] = [
            'codebond' => $row['codebond'],
            'bondcode' => $row['bondcode'],
            'bondreason' => $row['bondreason'],
            'bondvalue' => (float) $row['bondvalue'],
            'bondnro' => $row['bondnro'],
            'bondfee' => (float) $row['bondfee'],
            'fecha' => $row['fecha'],
            'bondelete' => (int) $row['bondelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'bonds' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}