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
    $sqlTotal = "SELECT COUNT(*) as total FROM area 
             WHERE (codearea LIKE :buscar OR areaname LIKE :buscar) ORDER BY codearea ASC";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalAreas = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalAreas / $limite);

    $sqlAreas = "
        SELECT 
            codearea, 
            areaname, 
            areadelete
        FROM area
        WHERE (codearea LIKE :buscar OR areaname LIKE :buscar)
        ORDER BY codearea DESC
        LIMIT :inicio, :limite
    ";
    $stmtAreas = $conn->prepare($sqlAreas);
    $stmtAreas->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtAreas->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtAreas->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtAreas->execute();
    $areas = $stmtAreas->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($areas as $row) {
        $data[] = [
            'codearea' => $row['codearea'],
            'areaname' => $row['areaname'],
            'areadelete' => (int) $row['areadelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'areas' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

