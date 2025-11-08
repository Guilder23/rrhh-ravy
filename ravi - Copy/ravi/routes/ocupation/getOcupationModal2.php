<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT codeoccupation, nameoccupation 
                            FROM occupation 
                            WHERE nameoccupation LIKE ? 
                            AND occupationdelete = 0 
                            LIMIT 10");

    $searchTerm = '%' . $q . '%';
    $stmt->bindParam(1, $searchTerm);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $occupationInfo = $row['codeoccupation'] . " - " . $row['nameoccupation'];
        echo "<div onclick='seleccionarOccupation(\"" . $row['codeoccupation'] . "\", \"" . $row['nameoccupation'] . "\")'>" . $occupationInfo . "</div>";
    }
}
?>