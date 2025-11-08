<?php
header('Content-Type: application/json');
require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $sql = "SELECT codecategory, namecategory FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['categorias' => $categorias]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
