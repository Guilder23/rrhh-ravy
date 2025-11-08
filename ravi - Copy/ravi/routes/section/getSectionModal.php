<?php

require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codesection = $_POST['codesection'] ?? null;

$sql = "SELECT codesection, namesection, sectiondelete FROM section WHERE codesection = :codesection";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codesection', $codesection, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$section = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($section);
?>
