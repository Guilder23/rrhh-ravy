<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['codeworker'])) {
    $codeworker = $_GET['codeworker'];

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM turnw WHERE codeworker = :codeworker");
    $stmt->bindParam(':codeworker', $codeworker);
    $stmt->execute();

    $turnosAsignados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['turnosAsignados' => $turnosAsignados]);
}
?>