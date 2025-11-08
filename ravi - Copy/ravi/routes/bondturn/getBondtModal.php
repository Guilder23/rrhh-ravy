<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codebondt = $_POST['codebondt'] ?? null;

$sql = "SELECT codebondt, codeturn, codebond, bondtdelete FROM bondt WHERE codebondt = :codebondt";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codebondt', $codebondt, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$bondt = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bondt) {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'No se encontr贸 la asignaci贸n de bono con el c贸digo proporcionado.']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($bondt);