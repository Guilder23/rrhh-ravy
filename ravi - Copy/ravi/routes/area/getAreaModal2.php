<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT codearea, areaname 
                            FROM area 
                            WHERE areaname LIKE ? 
                            LIMIT 10");

    $searchTerm = '%' . $q . '%';
    $stmt->bindParam(1, $searchTerm);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $areaInfo = $row['codearea'] . " - " . $row['areaname'];
        echo "<div onclick='seleccionarArea(\"" . $row['codearea'] . "\", \"" . $row['areaname'] . "\")'>" . $areaInfo . "</div>";
    }
}
?>

