<?php

require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codeoccupation = $_POST['codeoccupation'] ?? null;

$sql = "SELECT codeoccupation, nameoccupation, occupationdelete FROM occupation WHERE codeoccupation = :codeoccupation";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codeoccupation', $codeoccupation, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$occupation = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($occupation);
?>
