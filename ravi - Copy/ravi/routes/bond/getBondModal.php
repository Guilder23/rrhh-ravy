<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codebond = $_POST['codebond'] ?? null;

$sql = "SELECT codebond, bondcode, bondreason, bondvalue, bondnro, bondfee, bondelete FROM bond WHERE codebond = :codebond";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codebond', $codebond, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$bond = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bond) {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Bono no encontrado']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($bond);