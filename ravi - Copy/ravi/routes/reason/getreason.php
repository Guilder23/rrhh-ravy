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
    $sqlTotal = "SELECT COUNT(*) as total FROM reason 
                 WHERE (codereason LIKE :buscar OR reasonname LIKE :buscar) 
                 ORDER BY codereason ASC";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalReasons = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalReasons / $limite);

    $sqlReasons = "
        SELECT 
            codereason, 
            reasonname, 
            reasondelete
        FROM reason
        WHERE (codereason LIKE :buscar OR reasonname LIKE :buscar)
        ORDER BY codereason DESC
        LIMIT :inicio, :limite
    ";
    $stmtReasons = $conn->prepare($sqlReasons);
    $stmtReasons->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtReasons->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtReasons->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtReasons->execute();
    $reasons = $stmtReasons->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($reasons as $row) {
        $data[] = [
            'codereason' => $row['codereason'],
            'reasonname' => $row['reasonname'],
            'reasondelete' => (int) $row['reasondelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'reasons' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}