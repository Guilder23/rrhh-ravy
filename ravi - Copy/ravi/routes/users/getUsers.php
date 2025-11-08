<?php
header('Content-Type: application/json');

require '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

// Configuración de la paginación
$limite = 10; // Número de registros por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $limite) - $limite : 0;

try {
    // Contar el número total de registros
    $sqlTotal = "SELECT COUNT(*) as total FROM user";
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->execute();
    $totalUsuarios = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPaginas = ceil($totalUsuarios / $limite);

    // Consulta para obtener los usuarios con sus categorías, paginada
    $sqlUsuarios = "SELECT user.codeuser, user.username, user.userci, user.userphone, user.useraddress, 
                           category.namecategory, user.userlogin, user.userpassword, user.userstate
                    FROM user
                    JOIN category ON user.usertype = category.codecategory
                    ORDER BY user.codeuser ASC
                    LIMIT :inicio, :limite";
    $stmtUsuarios = $conn->prepare($sqlUsuarios);
    $stmtUsuarios->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmtUsuarios->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmtUsuarios->execute();
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para enviar en JSON
    $data = [];
    foreach ($usuarios as $row) {
        $data[] = [
            'codeuser' => $row['codeuser'],
            'username' => $row['username'],
            'userci' => $row['userci'],
            'userphone' => $row['userphone'],
            'useraddress' => $row['useraddress'],
            'namecategory' => $row['namecategory'],
            'userlogin' => $row['userlogin'],
            'userpassword' => $row['userpassword'],
            'userstate' => $row['userstate']
        ];
    }

    // Enviar respuesta JSON
    echo json_encode([
        'pagina' => $pagina,
        'totalPaginas' => $totalPaginas,
        'usuarios' => $data
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
