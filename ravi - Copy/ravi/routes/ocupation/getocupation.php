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
    $sqlTotal = "SELECT COUNT(*) as total FROM occupation
             WHERE (codeoccupation  LIKE :buscar 
             OR nameoccupation LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalOccupations = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalOccupations / $limite);
    
    $sqlOccupations = "
        SELECT 
            codeoccupation, 
            nameoccupation, 
            occupationdelete
        FROM occupation
        WHERE (codeoccupation  LIKE :buscar 
        OR nameoccupation LIKE :buscar)
        ORDER BY codeoccupation DESC
        LIMIT :inicio, :limite
    ";
    $stmtOccupations = $conn->prepare($sqlOccupations);
    $stmtOccupations->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtOccupations->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtOccupations->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtOccupations->execute();
    $occupations = $stmtOccupations->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($occupations as $row) {
        $data[] = [
            'codeoccupation' => $row['codeoccupation'],
            'nameoccupation' => $row['nameoccupation'],
            'occupationdelete' => (int) $row['occupationdelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'occupations' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

