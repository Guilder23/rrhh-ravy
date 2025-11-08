<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT codeworker, workercode, 
        CONCAT(
        COALESCE(workername1, ''), ' ', 
        COALESCE(workername2, ''), ' ', 
        COALESCE(workerlastname1, ''), ' ', 
        COALESCE(workerlastname2, '')
        ) AS fullname 
        FROM worker 
        WHERE workercode LIKE ? OR 
              workername1 LIKE ? OR 
              workername2 LIKE ? OR 
              workerlastname1 LIKE ? OR 
              workerlastname2 LIKE ? 
        LIMIT 10");

    $searchTerm = '%' . $q . '%';
    $stmt->bindParam(1, $searchTerm);
    $stmt->bindParam(2, $searchTerm);
    $stmt->bindParam(3, $searchTerm);
    $stmt->bindParam(4, $searchTerm);
    $stmt->bindParam(5, $searchTerm);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fullName = $row['workercode'] . " - " . $row['fullname'];
        echo "<div onclick='seleccionarSugerencia(\"" . $row['codeworker'] . "\", \"" . $row['fullname'] . "\", \"" . $row['workercode'] . "\")'>" . $fullName . "</div>";
    }
}
?>
