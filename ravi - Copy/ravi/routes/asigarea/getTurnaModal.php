<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codeturna = $_POST['codeturna'] ?? null;

$sql = "SELECT codeturna, codearea, codeturn, turnaname, turnalastname, turnacreate, turnadelete FROM turna WHERE codeturna = :codeturna";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codeturna', $codeturna, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$turna = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($turna);