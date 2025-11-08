<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codeturnw = $_POST['codeturnw'] ?? null;

$sql = "SELECT codeturnw, codeworker, codeturn, turnwdelete FROM turnw WHERE codeturnw = :codeturnw";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codeturnw', $codeturnw, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$turnw = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($turnw);
