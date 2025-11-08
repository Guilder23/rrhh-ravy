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
                 FROM turna ta
                 JOIN area a ON ta.codearea = a.codearea
                 JOIN turn t ON ta.codeturn = t.codeturn
                 WHERE (a.areaname LIKE :buscar OR 
                        CONCAT(
                            COALESCE(ta.turnaname, ''), ' ', 
                            COALESCE(ta.turnalastname, '')
                        ) LIKE :buscar)";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTotal->execute();
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalRegistros / $limite);

    $sqlTurnas = "
        SELECT 
            ta.codeturna,
            ta.turnacreate,
            a.areaname, 
            CONCAT(
                COALESCE(ta.turnaname, ''), ' ', 
                COALESCE(ta.turnalastname, '')
            ) AS asigfullname,
            t.turnname, 
            t.turnstart, 
            t.turnend,
            ta.turnadelete
        FROM turna ta
        JOIN area a ON ta.codearea = a.codearea
        JOIN turn t ON ta.codeturn = t.codeturn
        WHERE (a.areaname LIKE :buscar OR 
               CONCAT(
                   COALESCE(ta.turnaname, ''), ' ', 
                   COALESCE(ta.turnalastname, '')
               ) LIKE :buscar)
        ORDER BY ta.codeturna DESC
        LIMIT :inicio, :limite
    ";
    $stmtTurnas = $conn->prepare($sqlTurnas);
    $stmtTurnas->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
    $stmtTurnas->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtTurnas->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtTurnas->execute();
    $turnas = $stmtTurnas->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($turnas as $row) {
        $data[] = [
            'codeturna' => $row['codeturna'],
            'turnacreate' => $row['turnacreate'],
            'areaname' => $row['areaname'],
            'asigfullname' => $row['asigfullname'],
            'turnname' => $row['turnname'],
            'turnstart' => $row['turnstart'],
            'turnend' => $row['turnend'],
            'turnadelete' => $row['turnadelete']
        ];
    }

    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'turnas' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}