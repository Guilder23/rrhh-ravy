<?php
header('Content-Type: application/json');

require '../../config/database.php';

if (!isset($_GET['codecategory'])) {
    echo json_encode(['success' => false, 'error' => 'ID de categoría no proporcionado']);
    exit;
}

$codecategory = $_GET['codecategory'];

$db = new Database('local');
$conn = $db->getConnection();

if ($conn) {
    try {
        // Verificar si hay usuarios con esta categoría
        $sqlCheck = "SELECT COUNT(*) as total FROM user WHERE usertype = :codecategory";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':codecategory', $codecategory, PDO::PARAM_INT);
        $stmtCheck->execute();
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($result['total'] > 0) {
            echo json_encode([
                'success' => false, 
                'error' => 'No se puede eliminar la categoría porque tiene usuarios asignados'
            ]);
            exit;
        }
        
        // Eliminar la categoría
        $sql = "DELETE FROM category WHERE codecategory = :codecategory";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codecategory', $codecategory, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Categoría eliminada correctamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al eliminar la categoría']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
}
?>
