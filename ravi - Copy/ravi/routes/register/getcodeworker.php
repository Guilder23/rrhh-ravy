<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $q = trim($_GET['q']);

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT 
        codeworker, 
        workercode, 
        CONCAT(
            COALESCE(workername1, ''), ' ', 
            COALESCE(workername2, ''), ' ', 
            COALESCE(workerlastname1, ''), ' ', 
            COALESCE(workerlastname2, '')
        ) AS fullname, 
        workerrol,
        workerdateinit
        FROM 
            worker 
        WHERE 
            workercode LIKE ?
        LIMIT 10;");

    $searchTerm = '%' . $q . '%';
    $stmt->bindParam(1, $searchTerm);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codeworkerInfo = $row['workercode'] . " - " . $row['fullname'];
        echo "<div onclick='seleccionarCodeWorker(\"" . $row['codeworker'] . "\", \"" . $row['workercode'] . "\",\"" . $row['fullname'] . "\", \"" . $row['workerrol'] . "\", \"" . $row['workerdateinit'] . "\")'>" . $codeworkerInfo . "</div>";
    }
} else {
    echo "<div>No se ha proporcionado un término de búsqueda.</div>";
}
?>