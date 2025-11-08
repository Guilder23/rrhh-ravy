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
    $sqlTotal = "SELECT COUNT(*) as total FROM section 
                 WHERE (codesection LIKE :buscar OR namesection LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalSections = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalSections / $limite);

    $sqlSections = "
        SELECT 
            codesection, 
            namesection, 
            sectiondelete
        FROM section
        WHERE (codesection LIKE :buscar OR namesection LIKE :buscar)
        ORDER BY codesection DESC
        LIMIT :inicio, :limite
    ";
    $stmtSections = $conn->prepare($sqlSections);
    $stmtSections->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtSections->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtSections->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtSections->execute();
    $sections = $stmtSections->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($sections as $row) {
        $data[] = [
            'codesection' => $row['codesection'],
            'namesection' => $row['namesection'],
            'sectiondelete' => (int) $row['sectiondelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'sections' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}


