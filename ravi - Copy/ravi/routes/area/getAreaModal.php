<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

$codearea = $_POST['codearea'] ?? null;

$sql = "SELECT codearea, areaname, areadelete FROM area WHERE codearea = :codearea";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codearea', $codearea, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    exit;
}

$area = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($area);