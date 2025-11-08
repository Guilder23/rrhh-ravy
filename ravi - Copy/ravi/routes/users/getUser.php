<?php
header('Content-Type: application/json');

require '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

if (!isset($_GET['codeuser'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado']);
    exit;
}

$codeuser = $_GET['codeuser'];

try {
    // Consulta para obtener el usuario específico
    $sql = "SELECT user.codeuser, user.username, user.userci, user.userphone, user.useraddress, 
                   user.usertype, category.namecategory, user.userlogin, user.userpassword, 
                   user.useraccess, user.userstate
            FROM user
            JOIN category ON user.usertype = category.codecategory
            WHERE user.codeuser = :codeuser";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codeuser', $codeuser, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode([
            'success' => true,
            'usuario' => [
                'codeuser' => $usuario['codeuser'],
                'username' => $usuario['username'],
                'userci' => $usuario['userci'],
                'userphone' => $usuario['userphone'],
                'useraddress' => $usuario['useraddress'],
                'usertype' => $usuario['usertype'],
                'namecategory' => $usuario['namecategory'],
                'userlogin' => $usuario['userlogin'],
                'userpassword' => $usuario['userpassword'],
                'useraccess' => $usuario['useraccess'],
                'userstate' => $usuario['userstate']
            ]
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
